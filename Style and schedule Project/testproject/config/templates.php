<?php
return [
    'topbar' => [
        'field_name' => [
            'title' => 'text',
        ],
        'validation' => [
            'title.*' => 'required|max:100',
        ],
    ],

    'about-area' => [
        'field_name' => [
            'title' => 'text',
            'short_title' => 'text',
            'details' => 'textarea',
            'button_name_one' => 'text',
            'button_link_one' => 'url',
            'button_name_two' => 'text',
            'button_link_two' => 'url',
            'image' => 'file'
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'short_title.*' => 'required|max:200',
            'button_name_one.*' => 'required|max:2000',
            'button_link_one.*' => 'required|max:2000',
            'button_name_two.*' => 'required|max:2000',
            'button_link_two.*' => 'required|max:2000',
            'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
        ],
        'size' => [
            'image' => '346x346'
        ],

    ],

    'open-shop' => [
        'field_name' => [
            'title' => 'text',
            'address' => 'text',
            'image' => 'file'
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'address.*' => 'required|max:200',
            'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
        ],
        'size' => [
            'image' => '50x50'
        ],
    ],


    'experience' => [
        'field_name' => [
            'title' => 'text',
            'sub_title' => 'text',
            'image' => 'file'
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'sub_title.*' => 'required|max:200',
            'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
        ],
        'size' => [
            'image' => '519x627'
        ],
    ],

    'speciality' => [
        'field_name' => [
            'title' => 'text',
            'sub_title' => 'text',
            'image' => 'file'
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'sub_title.*' => 'required|max:200',
            'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
        ],
        'size' => [
            'image' => '531x688'
        ],
    ],

    'process-behind' => [
        'field_name' => [
            'title' => 'text',
            'video_link' => 'url',
            'short_details' => 'textarea',
            'image' => 'file',
            'background_image' => 'file'
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'video_link.*' => 'required|max:2000',
            'short_details.*' => 'required|max:2000',
            'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            'background_image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png'
        ],
        'size' => [
            'image' => '541x443'
        ],
    ],

    'testimonial' => [
        'field_name' => [
            'title' => 'text',
            'short_title' => 'text',
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'short_title.*' => 'required|max:300'
        ]
    ],

    'team' => [
        'field_name' => [
            'title' => 'text',
            'short_details' => 'text',
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'short_details.*' => 'required|max:300'
        ]
    ],


    'book-appointment' => [
        'field_name' => [
            'title' => 'text',
            'short_details' => 'text',
            'map_link' => 'url',
            'background_image' => 'file'
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'short_details.*' => 'required|max:300',
            'map_link.*' => 'required|max:2000',
            'background_image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png'
        ],
        'size' => [
            'image' => '1920x600',
        ],
    ],

    'why-chose-us' => [
        'field_name' => [
            'title' => 'text',
            'short_details' => 'textarea',
            'about_us_text_one' => 'text',
            'about_us_text_two' => 'text',
            'about_us_text_three' => 'text',
            'about_us_text_four' => 'text',
            'ceo_name' => 'text',
            'image' => 'file',
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'short_details.*' => 'required|max:2000',
            'about_us_text_one.*' => 'required|max:100',
            'about_us_text_two.*' => 'required|max:100',
            'about_us_text_three.*' => 'required|max:100',
            'about_us_text_four.*' => 'required|max:100',
            'ceo_name.*' => 'required|max:100',
            'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png'
        ],
        'size' => [
            'image' => '541x641',
        ],
    ],

    'about-us' => [
        'field_name' => [
            'title' => 'text',
            'sub_title' => 'text',
            'image' => 'file'

        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'sub_title.*' => 'required|max:200',
            'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png'
        ],
        'size' => [
            'image' => '531x531'
        ]
    ],

    'services' => [
        'field_name' => [
            'title' => 'text',
            'short_title' => 'text',
            'background_image' => 'file',
        ],
        'validation' => [
            'title.*' => 'required|max:50',
            'short_title.*' => 'required|max:200',
            'background_image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png'
        ]
    ],

    'gallery' => [
        'field_name' => [
            'title' => 'text',
            'sub_title' => 'text'
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'sub_title.*' => 'required|max:500'
        ]
    ],

    'login' => [
        'field_name' => [
            'title' => 'text',
            'image' => 'file',
            'logo_image' => 'file',
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
            'logo_image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png'
        ]
    ],

    'need-help' => [
        'field_name' => [
            'title' => 'text',
            'sub_title' => 'text',
            'phone' => 'text',
            'image' => 'file',
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'sub_title.*' => 'required|max:200',
            'phone.*' => 'required|max:20',
            'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
        ],
        'size' => [
            'image' => '350x337',
        ]
    ],


    'faq' => [
        'field_name' => [
            'title' => 'text',
            'sub_title' => 'text',
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'sub_title.*' => 'required|max:300',
        ]
    ],

    'plan' => [
        'field_name' => [
            'title' => 'text',
            'sub_title' => 'text',
        ],
        'validation' => [
            'title.*' => 'required|max:40',
            'sub_title.*' => 'required|max:500',
        ]
    ],

    'facts' => [
        'field_name' => [
            'title' => 'text',
            'sub_title' => 'text',
            'image' => 'file',
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'sub_title.*' => 'required|max:300',
            'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
        ],
        'size' => [
            'image' => '1920x590'
        ]
    ],

    'contact-us' => [
        'field_name' => [
            'heading' => 'text',
            'address' => 'text',
            'email_one' => 'text',
            'email_two' => 'text',
            'phone_one' => 'text',
            'phone_two' => 'text',
            'embed_map_link' => 'url',
            'short_details' => 'textarea'
        ],
        'validation' => [
            'heading.*' => 'nullable|max:100',
            'address.*' => 'nullable|max:2000',
            'email_one.*' => 'nullable|max:2000',
            'email_two.*' => 'nullable|max:2000',
            'phone_one.*' => 'nullable|max:2000',
            'phone_two.*' => 'nullable|max:2000',
            'embed_map_link' => 'nullable|max:2000',
            'short_details' => 'nullable|max:2000'
        ]
    ],
    'message' => [
        'required' => 'This field is required.',
        'min' => 'This field must be at least :min characters.',
        'max' => 'This field may not be greater than :max characters.',
        'image' => 'This field must be image.',
        'mimes' => 'This image must be a file of type: jpg, jpeg, png.',
    ],
    'template_media' => [
        'logo_image' => 'file',
        'image' => 'file',
        'thumbnail' => 'file',
        'youtube_link' => 'url',
        'button_link' => 'url',
        'button_link_one' => 'url',
        'button_link_two' => 'url',
        'video_link' => 'url',
        'embed_map_link' => 'url',
        'background_image' => 'file'

    ],

    'business-policy' => [
        'field_name' => [
            'delivery_policy' => 'text',
            'return_policy' => 'text',
        ],
        'validation' => [
            'delivery_policy.*' => 'required|max:300',
            'return_policy.*' => 'required|max:300'
        ]
    ],
];
