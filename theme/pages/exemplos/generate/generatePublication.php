<?php

use Faker\Provider\Image;
use Faker\Provider\Lorem;
use Theme\Pages\Publication\PublicationModel;

for ($count = 0; $count < 3; $count++) {
    $publication = new PublicationModel();
    $publication->title = Lorem::text(80);
    $publication->slug = slugify(substr($publication->title, 0, 15));
    $publication->description = Lorem::paragraphs(2, true);
    $publication->image = Image::image(ROOT . DS . 'theme' . DS . 'upload' . DS . 'publication', '300', '150');

    $publication->save();
    printr([
        'title' => $publication->title,
        'slug' => $publication->slug,
        'description' => $publication->description,
        'image' => $publication->image
    ]);
}
