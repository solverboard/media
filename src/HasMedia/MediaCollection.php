<?php

namespace Brackets\Media\HasMedia;

use Exception;

/**
 * TODO: popis
 *
 * @property-read string $name
 * @property-read string $title
 * @property-read string $disk
 * @property-read int $maxNumberOfFiles
 * @property-read int $maxFilesize
 * @property-read string $acceptedFileTypes
 * @property-read string $viewPermission
 * @property-read string $uploadPermission
 */

class MediaCollection  {

    protected $name;
    protected $title;
    protected $disk;
    protected $is_image = false;
    protected $maxNumberOfFiles;
    protected $maxFilesize;
    protected $acceptedFileTypes;
    protected $viewPermission;
    protected $uploadPermission;


    public function __construct(string $name) {
        $this->name = $name;
        $this->disk = config('media-collections.public_disk', 'media');
    }

    public function __get($property) {
        switch ($property) {
            case 'name':
                return $this->name;

            case 'title':
                return $this->title;

            case 'disk':
                return $this->disk;

            case 'maxNumberOfFiles':
                return $this->maxNumberOfFiles;

            case 'maxFilesize':
                return $this->maxFilesize;

            case 'acceptedFileTypes':
                return $this->acceptedFileTypes;

            case 'viewPermission':
                return $this->viewPermission;

            case 'uploadPermission';
                return $this->uploadPermission;
        }

        throw new Exception("Property [".$property."] does not exist");   
    }

    public static function create(string $name) {
        return new static($name);
    }

    // FIXME should it be here?
    public function title($title) {
        $this->title = $title;
        return $this;
    }

    /**
     * Set this collection contains an images. This allows the conversions functionality.
     *
     * @return $this
     */
    public function image() {
        $this->is_image = true;
        return $this;
    }

    /**
     * Specify a disk where to store this collection
     *
     * @param $disk
     * @return $this
     */
    public function disk($disk) {
        $this->disk = $disk;
        return $this;
    }

    /**
     * Alias to setting default private disk
     *
     * @return $this
     */
    public function private() {
        $this->disk = config('media-collections.private_disk');
        return $this;
    }

    public function maxNumberOfFiles($maxNumberOfFiles) {
        $this->maxNumberOfFiles = $maxNumberOfFiles;
        return $this;
    }

    public function maxFilesize($maxFilesize) {
        $this->maxFilesize = $maxFilesize;
        return $this;
    }


    //TODO: format? string, array or ...$x ? 
    public function accepts($acceptedFileTypes) {
        $this->acceptedFileTypes = $acceptedFileTypes;
        return $this;
    }

    public function canView($viewPermission) {
        $this->viewPermission = $viewPermission;
        return $this;
    }

    public function canUpload($uploadPermission) {
        $this->uploadPermission = $uploadPermission;
        return $this;
    }


    public function isImage() {
        return $this->is_image;
    }

    //FIXME: metoda disk by mohla mat druhy nepovinny paramater private, ktory len nastavi interny flag na true. Aby sme vedeli presnejsie ci ide o private alebo nie
    public function isPrivate() {
        return $this->disk == config('media-collections.private_disk');
    }
}