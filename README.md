# carcondor-yii2
YII2 helper functions.


## Installation

Add repository details to composer.json

     "repositories": [
            {
                "type": "composer",
                "url": "https://asset-packagist.org"
            },
            ....
            {
                "type": "vcs",
                "url": "git@github.com:datacondor/cc-yii2.git"
            },
            ....
        ]
        
Install library: 

add to composer.json        
        
        "require": {
            .....
            "carcondor/yii2" : "dev-master",
            .....    
        },
        
Or 

    php composer.phar require  "carcondor/url" "dev/master"        

## Configuration 

Set component in app configuration

This step is optional, you can instantiate required class in place. @todo doc is incomplete




## Usage

Use it:

    Yii::$app->url->doSomething();