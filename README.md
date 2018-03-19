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
                "url": "git@github.com:datacondor/yii2-widgets.git"
            },
            ....
        ]
        
Install library: 

add to composer.json        
        
        "require": {
            .....
            "datacondor/yii2-widgets" : "dev-master",
            .....    
        },
        
Or 

    php composer.phar require  "datacondor/yii2-widgets" "dev/master"        

## Configuration 

Set component in app configuration

This step is optional, you can instantiate required class in place. @todo doc is incomplete




## Usage

Use it:

    Yii::$app->url->doSomething();
    
## Gii generator for boxes    
             'generators' => [
                'myCrud' => [
                    'class' => 'ccyii\gii\generators\crud\Generator',
                    /*'templates' => [
                        'my' => '@app/myTemplates/crud/default',
                    ]*/
                ]
            ],