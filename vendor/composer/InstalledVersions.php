<?php











namespace Composer;

use Composer\Autoload\ClassLoader;
use Composer\Semver\VersionParser;








class InstalledVersions
{
private static $installed = array (
  'root' => 
  array (
    'pretty_version' => '1.0.0+no-version-set',
    'version' => '1.0.0.0',
    'aliases' => 
    array (
    ),
    'reference' => NULL,
    'name' => 'laravel/laravel',
  ),
  'versions' => 
  array (
    'bacon/bacon-qr-code' => 
    array (
      'pretty_version' => '1.0.3',
      'version' => '1.0.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '5a91b62b9d37cee635bbf8d553f4546057250bee',
    ),
    'brozot/laravel-fcm' => 
    array (
      'pretty_version' => '1.3.1',
      'version' => '1.3.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '1b5c64c5ea829f46c7e5f274971c587a8c3f0668',
    ),
    'components/jquery' => 
    array (
      'pretty_version' => '3.3.1',
      'version' => '3.3.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '459648cda77875519c5da3ae1dd0ed5d170aa649',
    ),
    'cordoval/hamcrest-php' => 
    array (
      'replaced' => 
      array (
        0 => '*',
      ),
    ),
    'davedevelopment/hamcrest-php' => 
    array (
      'replaced' => 
      array (
        0 => '*',
      ),
    ),
    'defuse/php-encryption' => 
    array (
      'pretty_version' => 'v2.3.1',
      'version' => '2.3.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '77880488b9954b7884c25555c2a0ea9e7053f9d2',
    ),
    'dnoegel/php-xdg-base-dir' => 
    array (
      'pretty_version' => '0.1',
      'version' => '0.1.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '265b8593498b997dc2d31e75b89f053b5cc9621a',
    ),
    'doctrine/inflector' => 
    array (
      'pretty_version' => 'v1.2.0',
      'version' => '1.2.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e11d84c6e018beedd929cff5220969a3c6d1d462',
    ),
    'doctrine/instantiator' => 
    array (
      'pretty_version' => '1.0.5',
      'version' => '1.0.5.0',
      'aliases' => 
      array (
      ),
      'reference' => '8e884e78f9f0eb1329e445619e04456e64d8051d',
    ),
    'erusev/parsedown' => 
    array (
      'pretty_version' => '1.7.1',
      'version' => '1.7.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '92e9c27ba0e74b8b028b111d1b6f956a15c01fc1',
    ),
    'firebase/php-jwt' => 
    array (
      'pretty_version' => 'v5.4.0',
      'version' => '5.4.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd2113d9b2e0e349796e72d2a63cf9319100382d2',
    ),
    'fzaninotto/faker' => 
    array (
      'pretty_version' => 'v1.8.0',
      'version' => '1.8.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f72816b43e74063c8b10357394b6bba8cb1c10de',
    ),
    'guzzlehttp/guzzle' => 
    array (
      'pretty_version' => '6.5.5',
      'version' => '6.5.5.0',
      'aliases' => 
      array (
      ),
      'reference' => '9d4290de1cfd701f38099ef7e183b64b4b7b0c5e',
    ),
    'guzzlehttp/promises' => 
    array (
      'pretty_version' => '1.4.0',
      'version' => '1.4.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '60d379c243457e073cff02bc323a2a86cb355631',
    ),
    'guzzlehttp/psr7' => 
    array (
      'pretty_version' => '1.7.0',
      'version' => '1.7.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '53330f47520498c0ae1f61f7e2c90f55690c06a3',
    ),
    'hamcrest/hamcrest-php' => 
    array (
      'pretty_version' => 'v1.2.2',
      'version' => '1.2.2.0',
      'aliases' => 
      array (
      ),
      'reference' => 'b37020aa976fa52d3de9aa904aa2522dc518f79c',
    ),
    'illuminate/auth' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'illuminate/broadcasting' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'illuminate/bus' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'illuminate/cache' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'illuminate/config' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'illuminate/console' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'illuminate/container' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'illuminate/contracts' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'illuminate/cookie' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'illuminate/database' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'illuminate/encryption' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'illuminate/events' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'illuminate/exception' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'illuminate/filesystem' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'illuminate/hashing' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'illuminate/http' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'illuminate/log' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'illuminate/mail' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'illuminate/notifications' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'illuminate/pagination' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'illuminate/pipeline' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'illuminate/queue' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'illuminate/redis' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'illuminate/routing' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'illuminate/session' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'illuminate/support' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'illuminate/translation' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'illuminate/validation' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'illuminate/view' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'jakub-onderka/php-console-color' => 
    array (
      'pretty_version' => 'v0.2',
      'version' => '0.2.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd5deaecff52a0d61ccb613bb3804088da0307191',
    ),
    'jakub-onderka/php-console-highlighter' => 
    array (
      'pretty_version' => 'v0.4',
      'version' => '0.4.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '9f7a229a69d52506914b4bc61bfdb199d90c5547',
    ),
    'kodova/hamcrest-php' => 
    array (
      'replaced' => 
      array (
        0 => '*',
      ),
    ),
    'laravel/framework' => 
    array (
      'pretty_version' => 'v5.4.36',
      'version' => '5.4.36.0',
      'aliases' => 
      array (
      ),
      'reference' => '1062a22232071c3e8636487c86ec1ae75681bbf9',
    ),
    'laravel/laravel' => 
    array (
      'pretty_version' => '1.0.0+no-version-set',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => NULL,
    ),
    'laravel/passport' => 
    array (
      'pretty_version' => 'v4.0.3',
      'version' => '4.0.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '0542f1f82edfbf857d0197c34a3d41f549aff30a',
    ),
    'laravel/tinker' => 
    array (
      'pretty_version' => 'v1.0.8',
      'version' => '1.0.8.0',
      'aliases' => 
      array (
      ),
      'reference' => 'cafbf598a90acde68985660e79b2b03c5609a405',
    ),
    'lcobucci/jwt' => 
    array (
      'pretty_version' => '3.4.5',
      'version' => '3.4.5.0',
      'aliases' => 
      array (
      ),
      'reference' => '511629a54465e89a31d3d7e4cf0935feab8b14c1',
    ),
    'league/event' => 
    array (
      'pretty_version' => '2.2.0',
      'version' => '2.2.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd2cc124cf9a3fab2bb4ff963307f60361ce4d119',
    ),
    'league/flysystem' => 
    array (
      'pretty_version' => '1.0.49',
      'version' => '1.0.49.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a63cc83d8a931b271be45148fa39ba7156782ffd',
    ),
    'league/oauth2-server' => 
    array (
      'pretty_version' => '6.1.1',
      'version' => '6.1.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a0cabb573c7cd5ee01803daec992d6ee3677c4ae',
    ),
    'league/oauth2server' => 
    array (
      'replaced' => 
      array (
        0 => '*',
      ),
    ),
    'lncd/oauth2' => 
    array (
      'replaced' => 
      array (
        0 => '*',
      ),
    ),
    'mockery/mockery' => 
    array (
      'pretty_version' => '0.9.10',
      'version' => '0.9.10.0',
      'aliases' => 
      array (
      ),
      'reference' => '4876fc0c7d9e5da49712554a35c94d84ed1e9ee5',
    ),
    'monolog/monolog' => 
    array (
      'pretty_version' => '1.24.0',
      'version' => '1.24.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'bfc9ebb28f97e7a24c45bdc3f0ff482e47bb0266',
    ),
    'mtdowling/cron-expression' => 
    array (
      'pretty_version' => 'v1.2.1',
      'version' => '1.2.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '9504fa9ea681b586028adaaa0877db4aecf32bad',
    ),
    'myclabs/deep-copy' => 
    array (
      'pretty_version' => '1.7.0',
      'version' => '1.7.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '3b8a3a99ba1f6a3952ac2747d989303cbd6b7a3e',
    ),
    'nesbot/carbon' => 
    array (
      'pretty_version' => '1.36.2',
      'version' => '1.36.2.0',
      'aliases' => 
      array (
      ),
      'reference' => 'cd324b98bc30290f233dd0e75e6ce49f7ab2a6c9',
    ),
    'nikic/php-parser' => 
    array (
      'pretty_version' => 'v4.1.1',
      'version' => '4.1.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '8aae5b59b83bb4d0dbf07b0a835f2680a658f610',
    ),
    'paragonie/random_compat' => 
    array (
      'pretty_version' => 'v2.0.17',
      'version' => '2.0.17.0',
      'aliases' => 
      array (
      ),
      'reference' => '29af24f25bab834fcbb38ad2a69fa93b867e070d',
    ),
    'phpdocumentor/reflection-common' => 
    array (
      'pretty_version' => '1.0.1',
      'version' => '1.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '21bdeb5f65d7ebf9f43b1b25d404f87deab5bfb6',
    ),
    'phpdocumentor/reflection-docblock' => 
    array (
      'pretty_version' => '4.3.0',
      'version' => '4.3.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '94fd0001232e47129dd3504189fa1c7225010d08',
    ),
    'phpdocumentor/type-resolver' => 
    array (
      'pretty_version' => '0.4.0',
      'version' => '0.4.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '9c977708995954784726e25d0cd1dddf4e65b0f7',
    ),
    'phpseclib/phpseclib' => 
    array (
      'pretty_version' => '2.0.32',
      'version' => '2.0.32.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f5c4c19880d45d0be3e7d24ae8ac434844a898cd',
    ),
    'phpspec/prophecy' => 
    array (
      'pretty_version' => '1.8.0',
      'version' => '1.8.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '4ba436b55987b4bf311cb7c6ba82aa528aac0a06',
    ),
    'phpunit/php-code-coverage' => 
    array (
      'pretty_version' => '4.0.8',
      'version' => '4.0.8.0',
      'aliases' => 
      array (
      ),
      'reference' => 'ef7b2f56815df854e66ceaee8ebe9393ae36a40d',
    ),
    'phpunit/php-file-iterator' => 
    array (
      'pretty_version' => '1.4.5',
      'version' => '1.4.5.0',
      'aliases' => 
      array (
      ),
      'reference' => '730b01bc3e867237eaac355e06a36b85dd93a8b4',
    ),
    'phpunit/php-text-template' => 
    array (
      'pretty_version' => '1.2.1',
      'version' => '1.2.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '31f8b717e51d9a2afca6c9f046f5d69fc27c8686',
    ),
    'phpunit/php-timer' => 
    array (
      'pretty_version' => '1.0.9',
      'version' => '1.0.9.0',
      'aliases' => 
      array (
      ),
      'reference' => '3dcf38ca72b158baf0bc245e9184d3fdffa9c46f',
    ),
    'phpunit/php-token-stream' => 
    array (
      'pretty_version' => '2.0.2',
      'version' => '2.0.2.0',
      'aliases' => 
      array (
      ),
      'reference' => '791198a2c6254db10131eecfe8c06670700904db',
    ),
    'phpunit/phpunit' => 
    array (
      'pretty_version' => '5.7.27',
      'version' => '5.7.27.0',
      'aliases' => 
      array (
      ),
      'reference' => 'b7803aeca3ccb99ad0a506fa80b64cd6a56bbc0c',
    ),
    'phpunit/phpunit-mock-objects' => 
    array (
      'pretty_version' => '3.4.4',
      'version' => '3.4.4.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a23b761686d50a560cc56233b9ecf49597cc9118',
    ),
    'psr/http-message' => 
    array (
      'pretty_version' => '1.0.1',
      'version' => '1.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f6561bf28d520154e4b0ec72be95418abe6d9363',
    ),
    'psr/http-message-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0',
      ),
    ),
    'psr/log' => 
    array (
      'pretty_version' => '1.1.0',
      'version' => '1.1.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '6c001f1daafa3a3ac1d8ff69ee4db8e799a654dd',
    ),
    'psr/log-implementation' => 
    array (
      'provided' => 
      array (
        0 => '1.0.0',
        1 => '1.0',
      ),
    ),
    'psy/psysh' => 
    array (
      'pretty_version' => 'v0.9.9',
      'version' => '0.9.9.0',
      'aliases' => 
      array (
      ),
      'reference' => '9aaf29575bb8293206bb0420c1e1c87ff2ffa94e',
    ),
    'ralouphie/getallheaders' => 
    array (
      'pretty_version' => '3.0.3',
      'version' => '3.0.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '120b605dfeb996808c31b6477290a714d356e822',
    ),
    'ramsey/uuid' => 
    array (
      'pretty_version' => '3.8.0',
      'version' => '3.8.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'd09ea80159c1929d75b3f9c60504d613aeb4a1e3',
    ),
    'rhumsaa/uuid' => 
    array (
      'replaced' => 
      array (
        0 => '3.8.0',
      ),
    ),
    'sebastian/code-unit-reverse-lookup' => 
    array (
      'pretty_version' => '1.0.1',
      'version' => '1.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '4419fcdb5eabb9caa61a27c7a1db532a6b55dd18',
    ),
    'sebastian/comparator' => 
    array (
      'pretty_version' => '1.2.4',
      'version' => '1.2.4.0',
      'aliases' => 
      array (
      ),
      'reference' => '2b7424b55f5047b47ac6e5ccb20b2aea4011d9be',
    ),
    'sebastian/diff' => 
    array (
      'pretty_version' => '1.4.3',
      'version' => '1.4.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '7f066a26a962dbe58ddea9f72a4e82874a3975a4',
    ),
    'sebastian/environment' => 
    array (
      'pretty_version' => '2.0.0',
      'version' => '2.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '5795ffe5dc5b02460c3e34222fee8cbe245d8fac',
    ),
    'sebastian/exporter' => 
    array (
      'pretty_version' => '2.0.0',
      'version' => '2.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'ce474bdd1a34744d7ac5d6aad3a46d48d9bac4c4',
    ),
    'sebastian/global-state' => 
    array (
      'pretty_version' => '1.1.1',
      'version' => '1.1.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'bc37d50fea7d017d3d340f230811c9f1d7280af4',
    ),
    'sebastian/object-enumerator' => 
    array (
      'pretty_version' => '2.0.1',
      'version' => '2.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '1311872ac850040a79c3c058bea3e22d0f09cbb7',
    ),
    'sebastian/recursion-context' => 
    array (
      'pretty_version' => '2.0.0',
      'version' => '2.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '2c3ba150cbec723aa057506e73a8d33bdb286c9a',
    ),
    'sebastian/resource-operations' => 
    array (
      'pretty_version' => '1.0.0',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'ce990bb21759f94aeafd30209e8cfcdfa8bc3f52',
    ),
    'sebastian/version' => 
    array (
      'pretty_version' => '2.0.1',
      'version' => '2.0.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '99732be0ddb3361e16ad77b68ba41efc8e979019',
    ),
    'simplesoftwareio/simple-qrcode' => 
    array (
      'pretty_version' => '2.0.0',
      'version' => '2.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '90b2282dd29be1e52565e9832dc23af41610ea07',
    ),
    'swiftmailer/swiftmailer' => 
    array (
      'pretty_version' => 'v5.4.12',
      'version' => '5.4.12.0',
      'aliases' => 
      array (
      ),
      'reference' => '181b89f18a90f8925ef805f950d47a7190e9b950',
    ),
    'symfony/console' => 
    array (
      'pretty_version' => 'v3.4.20',
      'version' => '3.4.20.0',
      'aliases' => 
      array (
      ),
      'reference' => '8f80fc39bbc3b7c47ee54ba7aa2653521ace94bb',
    ),
    'symfony/css-selector' => 
    array (
      'pretty_version' => 'v3.4.20',
      'version' => '3.4.20.0',
      'aliases' => 
      array (
      ),
      'reference' => '345b9a48595d1ab9630db791dbc3e721bf0233e8',
    ),
    'symfony/debug' => 
    array (
      'pretty_version' => 'v3.4.20',
      'version' => '3.4.20.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a2233f555ddf55e5600f386fba7781cea1cb82d3',
    ),
    'symfony/event-dispatcher' => 
    array (
      'pretty_version' => 'v3.4.20',
      'version' => '3.4.20.0',
      'aliases' => 
      array (
      ),
      'reference' => 'cc35e84adbb15c26ae6868e1efbf705a917be6b5',
    ),
    'symfony/finder' => 
    array (
      'pretty_version' => 'v3.4.20',
      'version' => '3.4.20.0',
      'aliases' => 
      array (
      ),
      'reference' => '6cf2be5cbd0e87aa35c01f80ae0bf40b6798e442',
    ),
    'symfony/http-foundation' => 
    array (
      'pretty_version' => 'v3.4.20',
      'version' => '3.4.20.0',
      'aliases' => 
      array (
      ),
      'reference' => 'ea61dd57c4399b0b2a4162e1820cd9d0783acd38',
    ),
    'symfony/http-kernel' => 
    array (
      'pretty_version' => 'v3.4.20',
      'version' => '3.4.20.0',
      'aliases' => 
      array (
      ),
      'reference' => '31f20eb6e00467ae85501dd98770aef17cd9aba7',
    ),
    'symfony/polyfill-ctype' => 
    array (
      'pretty_version' => 'v1.10.0',
      'version' => '1.10.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e3d826245268269cd66f8326bd8bc066687b4a19',
    ),
    'symfony/polyfill-intl-idn' => 
    array (
      'pretty_version' => 'v1.22.0',
      'version' => '1.22.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '0eb8293dbbcd6ef6bf81404c9ce7d95bcdf34f44',
    ),
    'symfony/polyfill-intl-normalizer' => 
    array (
      'pretty_version' => 'v1.22.0',
      'version' => '1.22.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '6e971c891537eb617a00bb07a43d182a6915faba',
    ),
    'symfony/polyfill-mbstring' => 
    array (
      'pretty_version' => 'v1.10.0',
      'version' => '1.10.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'c79c051f5b3a46be09205c73b80b346e4153e494',
    ),
    'symfony/polyfill-php70' => 
    array (
      'pretty_version' => 'v1.10.0',
      'version' => '1.10.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '6b88000cdd431cd2e940caa2cb569201f3f84224',
    ),
    'symfony/polyfill-php72' => 
    array (
      'pretty_version' => 'v1.22.0',
      'version' => '1.22.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'cc6e6f9b39fe8075b3dabfbaf5b5f645ae1340c9',
    ),
    'symfony/process' => 
    array (
      'pretty_version' => 'v3.4.20',
      'version' => '3.4.20.0',
      'aliases' => 
      array (
      ),
      'reference' => 'abb46b909dd6ba0b50e10d4c10ffe6ee96dd70f2',
    ),
    'symfony/psr-http-message-bridge' => 
    array (
      'pretty_version' => 'v1.2.0',
      'version' => '1.2.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '9ab9d71f97d5c7d35a121a7fb69f74fee95cd0ad',
    ),
    'symfony/routing' => 
    array (
      'pretty_version' => 'v3.4.20',
      'version' => '3.4.20.0',
      'aliases' => 
      array (
      ),
      'reference' => '94a3dd89bda078bef0c3bf79eb024fe136dd58f9',
    ),
    'symfony/translation' => 
    array (
      'pretty_version' => 'v3.4.20',
      'version' => '3.4.20.0',
      'aliases' => 
      array (
      ),
      'reference' => 'bdbe940ed3ef4179f86032086c32d3a858becc0f',
    ),
    'symfony/var-dumper' => 
    array (
      'pretty_version' => 'v3.4.20',
      'version' => '3.4.20.0',
      'aliases' => 
      array (
      ),
      'reference' => '6867713afe6c50ade2f34ed6435563b065a52145',
    ),
    'symfony/yaml' => 
    array (
      'pretty_version' => 'v3.4.20',
      'version' => '3.4.20.0',
      'aliases' => 
      array (
      ),
      'reference' => '291e13d808bec481eab83f301f7bff3e699ef603',
    ),
    'tightenco/collect' => 
    array (
      'replaced' => 
      array (
        0 => 'v5.4.36',
      ),
    ),
    'tijsverkoyen/css-to-inline-styles' => 
    array (
      'pretty_version' => '2.2.1',
      'version' => '2.2.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '0ed4a2ea4e0902dac0489e6436ebcd5bbcae9757',
    ),
    'vlucas/phpdotenv' => 
    array (
      'pretty_version' => 'v2.5.1',
      'version' => '2.5.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '8abb4f9aa89ddea9d52112c65bbe8d0125e2fa8e',
    ),
    'webmozart/assert' => 
    array (
      'pretty_version' => '1.4.0',
      'version' => '1.4.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '83e253c8e0be5b0257b881e1827274667c5c17a9',
    ),
    'zendframework/zend-diactoros' => 
    array (
      'pretty_version' => '1.8.7',
      'version' => '1.8.7.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a85e67b86e9b8520d07e6415fcbcb8391b44a75b',
    ),
  ),
);
private static $canGetVendors;
private static $installedByVendor = array();







public static function getInstalledPackages()
{
$packages = array();
foreach (self::getInstalled() as $installed) {
$packages[] = array_keys($installed['versions']);
}

if (1 === \count($packages)) {
return $packages[0];
}

return array_keys(array_flip(\call_user_func_array('array_merge', $packages)));
}









public static function isInstalled($packageName)
{
foreach (self::getInstalled() as $installed) {
if (isset($installed['versions'][$packageName])) {
return true;
}
}

return false;
}














public static function satisfies(VersionParser $parser, $packageName, $constraint)
{
$constraint = $parser->parseConstraints($constraint);
$provided = $parser->parseConstraints(self::getVersionRanges($packageName));

return $provided->matches($constraint);
}










public static function getVersionRanges($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

$ranges = array();
if (isset($installed['versions'][$packageName]['pretty_version'])) {
$ranges[] = $installed['versions'][$packageName]['pretty_version'];
}
if (array_key_exists('aliases', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['aliases']);
}
if (array_key_exists('replaced', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['replaced']);
}
if (array_key_exists('provided', $installed['versions'][$packageName])) {
$ranges = array_merge($ranges, $installed['versions'][$packageName]['provided']);
}

return implode(' || ', $ranges);
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getVersion($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['version'])) {
return null;
}

return $installed['versions'][$packageName]['version'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getPrettyVersion($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['pretty_version'])) {
return null;
}

return $installed['versions'][$packageName]['pretty_version'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getReference($packageName)
{
foreach (self::getInstalled() as $installed) {
if (!isset($installed['versions'][$packageName])) {
continue;
}

if (!isset($installed['versions'][$packageName]['reference'])) {
return null;
}

return $installed['versions'][$packageName]['reference'];
}

throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}





public static function getRootPackage()
{
$installed = self::getInstalled();

return $installed[0]['root'];
}







public static function getRawData()
{
return self::$installed;
}



















public static function reload($data)
{
self::$installed = $data;
self::$installedByVendor = array();
}





private static function getInstalled()
{
if (null === self::$canGetVendors) {
self::$canGetVendors = method_exists('Composer\Autoload\ClassLoader', 'getRegisteredLoaders');
}

$installed = array();

if (self::$canGetVendors) {
foreach (ClassLoader::getRegisteredLoaders() as $vendorDir => $loader) {
if (isset(self::$installedByVendor[$vendorDir])) {
$installed[] = self::$installedByVendor[$vendorDir];
} elseif (is_file($vendorDir.'/composer/installed.php')) {
$installed[] = self::$installedByVendor[$vendorDir] = require $vendorDir.'/composer/installed.php';
}
}
}

$installed[] = self::$installed;

return $installed;
}
}
