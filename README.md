MinimalOriginal ImageBundle
========

The image bundle for Minimal

Register bundle
========
$bundles = [
    ...
    new Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
    new Liip\ImagineBundle\LiipImagineBundle(),
    new MinimalOriginal\ImageBundle\MinimalImageBundle(),
];


Parameters
========
    amazon_s3_bucket_name: 'bucket.name.co'
    amazon_aws_key:         'xxxxx'
    amazon_aws_secret_key:  'xxxxx'
    amazon_s3_base_url:     'http://bucket.name.co.s3-website.eu-central-1.amazonaws.com'
    amazon_s3_region:  'eu-central-1'
    amazon_s3_version: 'latest'

routing
========
_liip_imagine:
    resource: "@LiipImagineBundle/Resources/config/routing.xml"
