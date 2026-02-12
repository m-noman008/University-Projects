<?php
return [

    'hero' => [
        'field_name' => [
            'title' => 'text',
            'button_name' => 'text',
            'button_link' => 'url',
            'image' => 'file',
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'button_name.*' => 'required|max:2000',
            'button_link.*' => 'required|max:2000',
            'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
        ],
        'size' => [
            'image' => '1920x768'
        ]
    ],


    'open-shop-schedule' => [
        'field_name' => [
            'day' => 'text',
            'time' => 'text',
        ],
        'validation' => [
            'day.*' => 'required|max:100',
            'time.*' => 'required|max:200',
        ]
    ],

    'experience' => [
        'field_name' => [
            'title' => 'text',
            'image' => 'file',
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png'
        ],
        'size' => [
            'image' => '40x44'
        ]
    ],

    'speciality' => [
        'field_name' => [
            'title' => 'text',
            'short_details' => 'text',
            'image' => 'file',
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'short_details.*' => 'required|max:100',
            'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png'
        ],
        'size' => [
            'image' => '35x35'
        ]
    ],

    'testimonial' => [
        'field_name' => [
            'name' => 'text',
            'designation' => 'text',
            'description' => 'textarea',
            'image' => 'file'
        ],
        'validation' => [
            'name.*' => 'required|max:100',
            'designation.*' => 'required|max:2000',
            'description.*' => 'required|max:5000',
            'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png',
        ],
        'size' => [
            'image' => '346x532',
            'thumb' => '159x159',
        ],
    ],

    'facts' => [
        'field_name' => [
            'name' => 'text',
            'count' => 'text',
            'image' => 'file',
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'count.*' => 'required|max:100',
            'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png'
        ],
        'size' => [
            'image' => '50x50'
        ]
    ],

    'why-chose-us' => [
        'field_name' => [
            'title' => 'text',
            'image' => 'file',
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'image.*' => 'nullable|max:3072|image|mimes:jpg,jpeg,png'
        ],
        'size' => [
            'image' => '40x40'
        ]
    ],

    'faq' => [
        'field_name' => [
            'title' => 'text',
            'description' => 'textarea'
        ],
        'validation' => [
            'title.*' => 'required|max:190',
            'description.*' => 'required|max:9000'
        ]
    ],

    'social' => [
        'field_name' => [
            'name' => 'text',
            'icon' => 'icon',
            'link' => 'url',
        ],
        'validation' => [
            'name.*' => 'required|max:100',
            'icon.*' => 'required|max:100',
            'link.*' => 'required|max:100'
        ],
    ],
    'pages' => [
        'field_name' => [
            'title' => 'text',
            'description' => 'textarea'
        ],
        'validation' => [
            'title.*' => 'required|max:100',
            'description.*' => 'required|max:30000'
        ]
    ],


    'message' => [
        'required' => 'This field is required.',
        'min' => 'This field must be at least :min characters.',
        'max' => 'This field may not be greater than :max characters.',
        'image' => 'This field must be image.',
        'mimes' => 'This image must be a file of type: jpg, jpeg, png.',
        'integer' => 'This field must be an integer value',
    ],

    'content_media' => [
        'image' => 'file',
        'thumbnail' => 'file',
        'youtube_link' => 'url',
        'button_link' => 'url',
        'link' => 'url',
        'icon' => 'icon'
    ]
];
