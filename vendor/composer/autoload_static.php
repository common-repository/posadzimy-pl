<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticIniteed51fda40359c54da271676180d6c65
{
    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'Inspire_Labs\\Posadzimy\\' => 23,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Inspire_Labs\\Posadzimy\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Inspire_Labs\\Posadzimy\\Api_Client\\Auth' => __DIR__ . '/../..' . '/src/Api_Client/Auth.php',
        'Inspire_Labs\\Posadzimy\\Api_Client\\Auth_Static_Factory' => __DIR__ . '/../..' . '/src/Api_Client/Auth_Static_Factory.php',
        'Inspire_Labs\\Posadzimy\\Api_Client\\Client' => __DIR__ . '/../..' . '/src/Api_Client/Client.php',
        'Inspire_Labs\\Posadzimy\\Api_Client\\Client_Static_Factory' => __DIR__ . '/../..' . '/src/Api_Client/Client_Static_Factory.php',
        'Inspire_Labs\\Posadzimy\\Api_Client\\Request_Get_Value_Object' => __DIR__ . '/../..' . '/src/Api_Client/Request_Get_Value_Object.php',
        'Inspire_Labs\\Posadzimy\\Api_Client\\Request_Post_Value_Object' => __DIR__ . '/../..' . '/src/Api_Client/Request_Post_Value_Object.php',
        'Inspire_Labs\\Posadzimy\\Api_Client\\Request_Value_Object_Interface' => __DIR__ . '/../..' . '/src/Api_Client/Request_Value_Object_Interface.php',
        'Inspire_Labs\\Posadzimy\\Api_Client\\Response_Value_Object' => __DIR__ . '/../..' . '/src/Api_Client/Response_Value_Object.php',
        'Inspire_Labs\\Posadzimy\\App' => __DIR__ . '/../..' . '/src/App.php',
        'Inspire_Labs\\Posadzimy\\Backend\\Alerts' => __DIR__ . '/../..' . '/src/Backend/Alerts.php',
        'Inspire_Labs\\Posadzimy\\Backend\\Alerts_Static_Factory' => __DIR__ . '/../..' . '/src/Backend/Alerts_Static_Factory.php',
        'Inspire_Labs\\Posadzimy\\Backend\\Backend' => __DIR__ . '/../..' . '/src/Backend/Backend.php',
        'Inspire_Labs\\Posadzimy\\Backend\\Backend_Static_Factory' => __DIR__ . '/../..' . '/src/Backend/Backend_Static_Factory.php',
        'Inspire_Labs\\Posadzimy\\Backend\\Customizer_Demo' => __DIR__ . '/../..' . '/src/Backend/Customizer_Demo.php',
        'Inspire_Labs\\Posadzimy\\Backend\\Order' => __DIR__ . '/../..' . '/src/Backend/Order.php',
        'Inspire_Labs\\Posadzimy\\Backend\\Order_Static_Factory' => __DIR__ . '/../..' . '/src/Backend/Order_Static_Factory.php',
        'Inspire_Labs\\Posadzimy\\Backend\\Settings' => __DIR__ . '/../..' . '/src/Backend/Settings.php',
        'Inspire_Labs\\Posadzimy\\Backend\\Settings_Static_Factory' => __DIR__ . '/../..' . '/src/Backend/Settings_Static_Factory.php',
        'Inspire_Labs\\Posadzimy\\Email\\Custom_Email' => __DIR__ . '/../..' . '/src/Email/Custom_Email.php',
        'Inspire_Labs\\Posadzimy\\Email\\Custom_Email_Static_Factory' => __DIR__ . '/../..' . '/src/Email/Custom_Email_Static_Factory.php',
        'Inspire_Labs\\Posadzimy\\Email\\New_Order_Mail' => __DIR__ . '/../..' . '/src/Email/New_Order_Mail.php',
        'Inspire_Labs\\Posadzimy\\Email\\New_Order_Mail_Static_Factory' => __DIR__ . '/../..' . '/src/Email/New_Order_Mail_Static_Factory.php',
        'Inspire_Labs\\Posadzimy\\Frontend\\Cart' => __DIR__ . '/../..' . '/src/Frontend/Cart.php',
        'Inspire_Labs\\Posadzimy\\Frontend\\Cart_Static_Factory' => __DIR__ . '/../..' . '/src/Frontend/Cart_Static_Factory.php',
        'Inspire_Labs\\Posadzimy\\Frontend\\Checkout' => __DIR__ . '/../..' . '/src/Frontend/Checkout.php',
        'Inspire_Labs\\Posadzimy\\Frontend\\Checkout_Static_Factory' => __DIR__ . '/../..' . '/src/Frontend/Checkout_Static_Factory.php',
        'Inspire_Labs\\Posadzimy\\Frontend\\Frontend' => __DIR__ . '/../..' . '/src/Frontend/Frontend.php',
        'Inspire_Labs\\Posadzimy\\Frontend\\Frontend_Static_Factory' => __DIR__ . '/../..' . '/src/Frontend/Frontend_Static_Factory.php',
        'Inspire_Labs\\Posadzimy\\Frontend\\Order' => __DIR__ . '/../..' . '/src/Frontend/Order.php',
        'Inspire_Labs\\Posadzimy\\Frontend\\Order_Static_Factory' => __DIR__ . '/../..' . '/src/Frontend/Order_Static_Factory.php',
        'Inspire_Labs\\Posadzimy\\Frontend\\Product_Single' => __DIR__ . '/../..' . '/src/Frontend/Product_Single.php',
        'Inspire_Labs\\Posadzimy\\Frontend\\Product_Single_Static_Factory' => __DIR__ . '/../..' . '/src/Frontend/Product_Single_Static_Factory.php',
        'Inspire_Labs\\Posadzimy\\Utils\\Cart_Helper' => __DIR__ . '/../..' . '/src/Utils/Cart_Helper.php',
        'Inspire_Labs\\Posadzimy\\Utils\\Cart_Helper_Static_Factory' => __DIR__ . '/../..' . '/src/Utils/Cart_Helper_Static_Factory.php',
        'Inspire_Labs\\Posadzimy\\Utils\\Config_Validator' => __DIR__ . '/../..' . '/src/Utils/Config_Validator.php',
        'Inspire_Labs\\Posadzimy\\Utils\\Config_Validator_Static_Factory' => __DIR__ . '/../..' . '/src/Utils/Config_Validator_Static_Factory.php',
        'Inspire_Labs\\Posadzimy\\Utils\\Credit_Balance' => __DIR__ . '/../..' . '/src/Utils/Credit_Balance.php',
        'Inspire_Labs\\Posadzimy\\Utils\\Credit_Balance_Static_Factory' => __DIR__ . '/../..' . '/src/Utils/Credit_Balance_Static_Factory.php',
        'Inspire_Labs\\Posadzimy\\Utils\\Order_Helper' => __DIR__ . '/../..' . '/src/Utils/Order_Helper.php',
        'Inspire_Labs\\Posadzimy\\Utils\\Order_Helper_Static_Factory' => __DIR__ . '/../..' . '/src/Utils/Order_Helper_Static_Factory.php',
        'Inspire_Labs\\Posadzimy\\Utils\\Settings_Helper' => __DIR__ . '/../..' . '/src/Utils/Settings_Helper.php',
        'Inspire_Labs\\Posadzimy\\Utils\\Settings_Static_Factory' => __DIR__ . '/../..' . '/src/Utils/Settings_Static_Factory.php',
        'Inspire_Labs\\Posadzimy\\Utils\\Utils' => __DIR__ . '/../..' . '/src/Utils/Utils.php',
        'Inspire_Labs\\Posadzimy\\Utils\\Utils_Static_Factory' => __DIR__ . '/../..' . '/src/Utils/Utils_Static_Factory.php',
        'Inspire_Labs\\Posadzimy\\Virtual_Product\\Virtual_Product_Value_Object' => __DIR__ . '/../..' . '/src/Virtual_Product/Virtual_Product_Value_Object.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticIniteed51fda40359c54da271676180d6c65::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticIniteed51fda40359c54da271676180d6c65::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticIniteed51fda40359c54da271676180d6c65::$classMap;

        }, null, ClassLoader::class);
    }
}
