<?php namespace Easypay;

use Exception;

/**
 * Class EasyPay
 * Contains the methods that wrap the API calls
 *
 * @package Easypay
 */
class EasyPay
{
    /**
     * URL for the testing endpoint
     *
     * @var string
     */
    private $testEndpoint = 'http://test.easypay.pt/_s/';

    /**
     * URL for the production endpoint
     *
     * @var string
     */
    private $productionEndpoint = 'https://www.easypay.pt/_s/';

    /**
     * Variable that will contain all the request's parameters for a single SOAP request
     *
     * @var array
     */
    private $uri = [];

    /**
     * Indicates which endpoint should be used
     * `false` if you're on development and `true` if you intend to use the production server
     *
     * @var bool
     */
    private $liveMode = false;

    /**
     * Country code (ISO-3301-alpha2 - whatever this is)
     * Must correspond to the ISO-3301-alpha2 country code for the CIN
     * Example: PT, GB, FR
     *
     * @var string
     */
    private $country = 'PT';

    /**
     * Required parameter that is used when you're requesting a ADC (Autorização débito em conta)
     * This is used to know which language should the Easypay gateway be displayed
     * Example: PT, EN, ES or FR
     *
     * @var string
     */
    private $language = 'PT';

    /**
     * Not really sure what this does, since the unique allowed value is 'auto'
     *
     * @var string
     */
    private $refType = 'auto';

    /**
     * The Easypay user account (the one you use when you login to their backoffice)
     *
     * @var string
     */
    private $user = '';

    /**
     * The CIN (Client Identification Number) you want to use for the requests
     * This value will always be a 6 digit number
     *
     * @var string
     */
    private $cin = '123456';

    /**
     * The entity associated to your Easypay account
     * This value will always be a 5 digit number
     *
     * @var string
     */
    private $entity = '12345';

    /**
     * Optional for "Multibanco" requests, but required for all other methods.
     * Should indicate the name of the end client that will be charged
     *
     * @var string
     */
    private $name = '';

    /**
     * Optional description for the payment
     *
     * @var string
     */
    private $description = '';

    /**
     * Optional (?) value to add the observations you want on the request
     *
     * @var string
     */
    private $observation = '';

    /**
     * The end client's phone number, that will be filled automatically on Easypay's gateway
     *
     * @var string
     */
    private $mobile = '';

    /**
     * The end client's email address, that will be filled automatically on Easypay's gateway
     *
     * @var string
     */
    private $email = '';

    /**
     * The amount the user should be charged.
     * This value is a double and you MUST use '.' as a separator for decimal separator
     *
     * @var string
     */
    private $value = '0.0';

    /**
     * The identifier of the payment. This will serve to cross-reference the order in
     * your system with the payment on Easypay's system
     *
     * @var string
     */
    private $key = '';

    /**
     * Stores the request logs
     *
     * @var array
     */
    private $logs = [];

    /**
     * Indicates the frequency of the payments when using Direct debit payments
     * Example: 2W (2 weeks), 1M (one month), ...
     *
     * @var string
     */
    private $epRecFreq = "2W";

    /**
     * URL when Easypay gateway should redirect the user when you're using their
     * gateway AND the payment method is Direct Debit
     * @var string
     */
    private $redirectUrl;

    /**
     * Indicates if you are using the code authentication or not.
     * If false, the `s_code` parameter will not be sent. Otherwise, this parameter
     * should be a string with the authentication code
     * @var bool|string
     */
    private $code = false;

    /**
     * Handler for easypay communications
     * @param array $params
     */
    public function __construct($params = [])
    {
        foreach ($params as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Set current working mode
     *
     * @param bool $boolean True if production mode. False if test mode
     */
    public function setLive($boolean = false)
    {
        $this->liveMode = $boolean;
    }

    /**
     * Creates a New Reference (API 01BG)
     * @see https://docs.easypay.pt/api/01BG
     *
     * @param string $type ["normal", "boleto", "recurring", "moto"]
     * @return array
     */
    public function createReference($type = 'normal')
    {
        $this->addUriParam('ep_user', $this->user);
        $this->addUriParam('ep_entity', $this->entity);
        $this->addUriParam('ep_cin', $this->cin);
        $this->addUriParam('t_value', $this->value);
        $this->addUriParam('t_key', $this->key);
        $this->addUriParam('ep_language', $this->language);
        $this->addUriParam('ep_country', $this->country);
        $this->addUriParam('ep_ref_type', $this->refType);
        $this->addUriParam('o_name', $this->name);
        $this->addUriParam('o_description', $this->description);
        $this->addUriParam('o_obs', $this->observation);
        $this->addUriParam('o_mobile', $this->mobile);
        $this->addUriParam('o_email', $this->email);

        switch ($type) {
            case 'boleto':
                $this->addUriParam('ep_type', 'boleto');
                break;

            case 'recurring':
                $this->addUriParam('ep_rec', 'yes');
                $this->addUriParam('ep_rec_freq', $this->epRecFreq);
                $this->addUriParam('ep_rec_url', $this->redirectUrl);
                break;

            case 'moto':
                $this->addUriParam('ep_type', 'moto');
                break;
        }

        return $this->xmlToArray(
            $this->getContents(
                $this->getUri('api_easypay_01BG.php')
            )
        );
    }

    /**
     * Request a Payment (API 05AG)
     * @see https://docs.easypay.pt/api/05AG
     *
     * @param array $params
     * @return array
     */
    public function requestPayment($params)
    {
        $this->addUriParam('e', $this->entity);
        $this->addUriParam('r', $params['r']);
        $this->addUriParam('v', $params['v']);
        $this->addUriParam('ep_k1', $params['ep_k1']);
        $this->addUriParam('rec', 'yes');
        $this->addUriParam('ep_key_rec', $params['ep_key_rec']);
        $this->addUriParam('request_date', $params['request_date']);

        return $this->xmlToArray(
            $this->getContents(
                $this->getUri('api_easypay_05AG.php')
            )
        );
    }

    /**
     * Returns an array with the requested payment information (API 03AG)
     * @see https://docs.easypay.pt/api/03AG
     *
     * @param array $initialPaymentInfo
     * @return array
     */
    public function getPaymentInfo($initialPaymentInfo)
    {
        $this->addUriParam('ep_user', $initialPaymentInfo['ep_user']);
        $this->addUriParam('ep_cin', $initialPaymentInfo['ep_cin']);
        $this->addUriParam('ep_doc', $initialPaymentInfo['ep_doc']);

        // This parameter may or may not be sent by Easypay, so we'll need to account for that
        if (array_key_exists('ep_type', $initialPaymentInfo)) {
            $this->addUriParam('ep_type', $initialPaymentInfo['ep_type']);
        }

        return $this->xmlToArray(
            $this->getContents(
                $this->getUri('api_easypay_03AG.php')
            )
        );
    }

    /**
     * Method that retrieves the "notifications" (API 040GB1)
     * @see https://docs.easypay.pt/api/040BG1
     *
     * @param array $params Array that can either be empty or have specific values
     *  if you want to use, for eg, the `o_list_type`
     * @param bool $onlyPayedStatus True if only payment indications (success) false for pending and errors.
     *  This is only needed when you're trying to fetch Direct Debit payment "notifications"
     * @return array
     */
    public function fetchAllPayments($params, $onlyPayedStatus = false)
    {
        $this->addUriParam('ep_cin', $this->cin);
        $this->addUriParam('ep_user', $this->user);
        $this->addUriParam('ep_entity', $this->entity);

        if (array_key_exists('o_list_type', $params)) {
            $this->addUriParam('o_list_type', $params['o_list_type']);
            $this->addUriParam('o_ini', $params['o_ini']);
            $this->addUriParam('o_last', $params['o_last']);
        }

        if (array_key_exists('ep_freq', $params)) {
            $this->addUriParam('ep_freq', $params['ep_freq']);
        }

        // If we want the request payment status, we send ep_rec=yes.
        // If we want the effective payment status, we won't send the ep_rec
        if (!$onlyPayedStatus) {
            $this->addUriParam('ep_rec', 'yes');
        }

        return $this->xmlToArray(
            $this->getContents(
                $this->getUri('api_easypay_040BG1.php')
            )
        );
    }

    /**
     * Performs the cUrl request to the SOAP endpoint and returns the data
     *
     * @param array $url
     * @param string $type
     * @return string
     * @throw Exception
     */
    private function getContents($url, $type = 'GET')
    {
        try {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
            if (strtoupper($type) == 'GET') {
                //curl_setopt($curl, CURLOPT_HTTPGET, TRUE);
            } elseif (strtoupper($type) == 'POST') {
                curl_setopt($curl, CURLOPT_POST, true);
            } else {
                throw new Exception('Communication Error, standart communication not selected, POST or GET required');
            }

            // Ignore SSL verification
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($curl);
            curl_close($curl);
        } catch (Exception $e) {
            $result = false;
        }

        $this->logs['contents'] = $result;

        return $result;
    }

    /**
     * Transforms the XML string into an array, so you can easily access the
     * hierarchy with keys
     *
     * @param $string
     * @return bool|mixed
     */
    private function xmlToArray($string)
    {
        try {
            $obj = simplexml_load_string($string);
            $data = json_decode(json_encode($obj), true);
        } catch (Exception $e) {
            $data = false;
        }

        $this->logs['contents_array'] = $data;

        return $data;
    }

    /**
     * Adds a parameter to the URI
     *
     * @param string $key
     * @param string $value
     */
    private function addUriParam($key, $value)
    {
        $this->uri[$key] = $value;
    }

    /**
     * Creates the request URL based on the server endpoint (production or test) and the
     * API url. Also append the uri parameters.
     * Once the URL is created, the `$this->uri` will be cleared
     *
     * @param string $apiEndpoint
     * @return string
     */
    private function getUri($apiEndpoint)
    {
        // Verify which endpoint should be used (either production od test)
        $str = $this->testEndpoint;

        if ($this->liveMode) {
            $str = $this->productionEndpoint;
        }

        $str .= $apiEndpoint;

        // Append the code to the request, if the authentication is performed via code
        if ($this->code) {
            $this->uri['s_code'] = $this->code;
        }

        // Prepare the URL properly
        // @todo: I think accented characters are buggy here ç, á, ..
        $tmp = str_replace(' ', '+', http_build_query($this->uri));
        $this->logs['params'] = $this->uri;
        $this->uri = [];

        $this->logs['url'] = $str . '?' . $tmp;

        return $str . '?' . $tmp;

    }

    /**
     * Returns the last operation logs
     *
     * @return array
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * Set field values based on user needs
     *
     * @param string $field this will specify the field we want to set
     * @param mixed  $value the new value for the field
     */
    public function setValue($field, $value)
    {
        $this->$field = $value;
    }

    /**
     * Get field information
     *
     * @param string $field specified the field we want to get the value
     *
     * @return mixed
     */
    public function getValue($field)
    {
        return $this->$field;
    }




    /**
     * BEWARE: Untested methods below!
     */

    /**
     * Returns an array with the transaction verification
     * @param string $reference
     * @return array
     */
    public function getTransactionVerification($reference)
    {
        $this->addUriParam('ep_cin', $this->cin);
        $this->addUriParam('ep_user', $this->user);
        $this->addUriParam('e', $this->entity);
        $this->addUriParam('r', $reference);
        $this->addUriParam('c', $this->country);

        return $this->xmlToArray(
            $this->getContents(
                $this->getUri('api_easypay_23AG.php')
            )
        );
    }

    /**
     * Updates the payment information. Name, Email, etc...
     *
     * @param integer $reference
     * @param double  $value
     * @param array   $data Optional Keys -> name, description, obs, email, mobile, t_key
     *
     * @return array
     */
    public function updatePayment($reference, $value, $data)
    {
        $this->addUriParam('ep_cin', $this->cin);
        $this->addUriParam('ep_user', $this->user);
        $this->addUriParam('ep_entity', $this->entity);
        $this->addUriParam('ep_ref', $reference);
        $this->addUriParam('t_value', $value);

        //Data handling
        if (isset($data['name'])) {
            $this->addUriParam('o_value', $data['name']);
        }
        if (isset($data['description'])) {
            $this->addUriParam('o_description', $data['description']);
        }
        if (isset($data['obs'])) {
            $this->addUriParam('o_obs', $data['obs']);
        }
        if (isset($data['email'])) {
            $this->addUriParam('o_email', $data['email']);
        }
        if (isset($data['mobile'])) {
            $this->addUriParam('o_mobile', $data['mobile']);
        }
        if (isset($data['t_key'])) {
            $this->addUriParam('t_key', $data['t_key']);
        }

        return $this->xmlToArray(
            $this->getContents(
                $this->getUri('api_easypay_00BG.php')
            )
        );
    }

    /**
     * Deletes a payment by reference
     *
     * @param integer $reference
     * @param double  $value
     *
     * @return array
     */
    public function deletePayment($reference, $value)
    {
        $this->addUriParam('ep_cin', $this->cin);
        $this->addUriParam('ep_user', $this->user);
        $this->addUriParam('ep_entity', $this->entity);
        $this->addUriParam('ep_ref', $reference);
        $this->addUriParam('ep_delete', 'yes');
        $this->addUriParam('t_value', $value);

        return $this->xmlToArray(
            $this->getContents(
                $this->getUri('api_easypay_00BG.php')
            )
        );
    }

    /**
     * Generates a reference with design from easypay
     * @param array $paymentTypes
     */
    public function createPaymentWithDesign($paymentTypes = [])
    {
        if (empty($paymentTypes)) {
            $paymentTypes = ['multibanco'];
        }
        if (in_array('boleto', $paymentTypes)) {
            $this->createReference('boleto');
        } else {
            $this->createReference();
        }
    }
}
