<?php

    namespace Theme\Pages\ProductImage;

    use Source\Controllers\Upload;
    use Source\Models\Model;

    class ProductImageModel extends Model
    {
        const IMAGES_FOLDER = ROOT . DS . 'theme' . DS . 'upload' . DS . 'product' . DS;

        public function __construct()
        {
            $this->setTable("product_images");

            parent::__construct("product_images", ["id_product", "image"]);
        }

        public function destroy(): bool
        {
            if (file_exists(self::IMAGES_FOLDER . $this->image)) {
                Upload::fileDestroy(self::IMAGES_FOLDER . $this->image);
            }

            return parent::destroy(); // TODO: Change the autogenerated stub
        }
    }