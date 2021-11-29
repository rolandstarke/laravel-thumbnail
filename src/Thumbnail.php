<?php

namespace Rolandstarke\Thumbnail;

use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Rolandstarke\Thumbnail\Filter\FilterInterface;


class Thumbnail
{
    /**
     * @var Source
     */
    protected $source;

    protected $renderedImage;

    protected $config;

    protected $preset = 'default';

    protected $params = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @throws Exception
     */
    public function preset(string $preset): self
    {
        if (!isset($this->config['presets'][$preset])) {
            throw new Exception('Preset "' . $preset . '" does not exist.');
        }
        $this->preset = $preset;
        return $this;
    }

    /**
     * @throws Exception
     */
    public function src(string $path, string $disk = null): self
    {
        $this->source = null;
        $source = new Source($this->config['allowedSources']);
        $source->src($path, $disk);
        $this->source = $source;
        return $this;
    }

    public function greyscale(): self
    {
        return $this->param('greyscale', '1');
    }

    /**
     * coution: blur with large images takes long
     */
    public function blur(int $amount = 1): self
    {
        return $this->param('blur', $amount);
    }

    public function smartcrop(int $width, int $height): self
    {
        return $this->param('smartcrop', $width . 'x' . $height);
    }

    public function crop(int $width, int $height): self
    {
        return $this->param('crop', $width . 'x' . $height);
    }

    public function widen(int $width): self
    {
        return $this->param('widen', $width);
    }

    public function heighten(int $height): self
    {
        return $this->param('heighten', $height);
    }

    /**
     *
     * @param string $format one of jpg, png, gif, webp
     * @param integer $quality 100-0 where 100 is best quality and 0 worst
     */
    public function format(string $format, int $quality = null): self
    {
        return $this->param('format', $format)->param('quality', $quality);
    }

    public function param(string $name, $value): self
    {
        $this->params[$name] = $value;
        return $this;
    }

    public function url(bool $ensurePresence = false): string
    {
        if ($this->source === null) {
            throw new Exception('can not get thumbnail url, set source image first ');
        }

        $destination = $this->config['presets'][$this->preset]['destination'];
        $outputPath = $destination['path'] . $this->getOutputFilename();

        if ($ensurePresence && !Storage::disk($destination['disk'])->exists($outputPath)) {
            $this->save();
        }

        return Storage::disk($destination['disk'])
            ->url($outputPath . '?' . http_build_query($this->getUrlParams()));
    }

    public function response(bool $useExisting = true): \Symfony\Component\HttpFoundation\Response
    {
        return response($this->getRenderedImage($useExisting), 200, ['content-type' => $this->getContentType()]);
    }

    public function string(bool $useExisting = true): string
    {
        return $this->getRenderedImage($useExisting);
    }

    public function save(): self
    {
        $destination = $this->config['presets'][$this->preset]['destination'];

        Storage::disk($destination['disk'])->put(
            $destination['path'] . $this->getOutputFilename(),
            $this->getRenderedImage()
        );

        return $this;
    }

    public function delete(): self
    {
        $destination = $this->config['presets'][$this->preset]['destination'];

        Storage::disk($destination['disk'])->delete(
            $destination['path'] . $this->getOutputFilename()
        );

        return $this;
    }


    /**
     * @internal
     */
    public function isValidRequest($filename): bool
    {
        return $this->source && $filename === $this->getOutputFilename();
    }

    /**
     * @throws Exception
     * @internal
     */
    public function setParamsFromUrl(array $urlParams): self
    {
        $this->source = null;
        $this->params = [];
        $source = new Source($this->config['allowedSources']);
        $source->setSrcFromUrlParams($urlParams);

        foreach ($source->urlParams as $key => $param) {
            unset($urlParams[$key]);
        }

        $this->params = $urlParams;
        $this->source = $source;
        return $this;
    }


    protected function getRenderedImage(bool $useExisting = false): string
    {
        if ($this->renderedImage === null) {

            if ($useExisting) {
                $destination = $this->config['presets'][$this->preset]['destination'];
                $outputPath = $destination['path'] . $this->getOutputFilename();

                try {
                    $this->renderedImage = Storage::disk($destination['disk'])->get($outputPath);
                } catch (Exception $exception) {
                    $this->renderedImage = null;
                }

                if (!$this->renderedImage) {
                    $this->save();
                }
            } else {
                $this->render();
            }
        }
        return $this->renderedImage;
    }

    protected function render(): self
    {
        if (!empty($this->config['memory_limit'])) {
            ini_set('memory_limit', $this->config['memory_limit']);
        }

        $params = array_merge(
            $this->config['presets'][$this->preset],
            $this->params
        );

        $image = Image::make($this->source->getImage());

        foreach (Arr::get($this->config, 'filters', []) as $filterClassName) {
            $filter = \Illuminate\Support\Facades\App::make($filterClassName);
            if ($filter instanceof FilterInterface) {
                $image = $filter->handle($image, $params);
            } else {
                throw new Exception('filter must be instanceof FilterInterface, given filter: "' . $filterClassName . '"');
            }
        }

        $this->renderedImage = (string)$image->encode($this->getFormat(), Arr::get($params, 'quality'));
        return $this;
    }

    protected function getUrlParams(): array
    {
        $params = array_merge(
            $this->source->urlParams,
            $this->params
        );

        //remove params from url that are the same as the preset to shorten it
        foreach ($this->config['presets'][$this->preset] as $param => $setting) {
            if (isset($params[$param]) && $params[$param] === $setting) {
                unset($params[$param]);
            }
        }

        //sort for better caching
        ksort($params);

        return $params;
    }

    protected function getOutputFilename(): string
    {
        $params = array_merge(
            $this->config['presets'][$this->preset],
            $this->source->urlParams,
            $this->params
        );

        $params['format'] = $this->getFormat();
        ksort($params);
        $salt = Arr::get($this->config, 'signing_key', '');

        $filename = base_convert(md5(http_build_query($params) . $salt), 16, 36) . '.' . $this->getFormat();
        $filename = substr_replace($filename, '/', 4, 0);
        $filename = substr_replace($filename, '/', 2, 0);

        return $filename;
    }

    protected function getFormat(): string
    {
        if (!empty($this->params['format'])) {
            return $this->params['format'];
        } else if (!empty($this->config['presets'][$this->preset]['format'])) {
            return $this->config['presets'][$this->preset]['format'];
        } else {
            return $this->source->getFormat();
        }
    }

    protected function getContentType(): string
    {
        return Arr::get([
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'webp' => 'image/webp',
            'ico' => 'image/x-icon',
            'gif' => 'image/gif',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'bmp' => 'image/bmp',
            'psd' => 'image/vnd.adobe.photoshop',
        ], $this->getFormat());
    }
}
