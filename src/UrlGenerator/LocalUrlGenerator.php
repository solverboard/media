<?php

namespace Brackets\Media\UrlGenerator;

use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\UrlGenerator\LocalUrlGenerator as SpatieLocalUrlGenerator;

class LocalUrlGenerator extends SpatieLocalUrlGenerator {

    public function getUrl(): string {
        if(Storage::disk($this->media->disk)->getConfig()->get('visibility') == 'private') {
            $url = $this->getPathRelativeToRoot();
            return route('brackets/media:view', [], false) . '?path=' . $this->makeCompatibleForNonUnixHosts($url);
        } else {
            $url = $this->getBaseMediaDirectory().'/'.$this->getPathRelativeToRoot();
            return $this->makeCompatibleForNonUnixHosts($url);
        }
    }
}
