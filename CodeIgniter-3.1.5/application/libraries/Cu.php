<?php

/**
 * Cu - искусственный интеллект преферанса
 * 
 * -- контроль пользователя
 *    (вход/перевход/выход/регистрация
 *     создание стола/присоединение
 *     участие в пулях 
 *     дисквалификация)
 * 
 * -- контроль престола 
 *        создание,
 *        ожидание,
 *        вынужденное завершение по таймеру,
 *        вынужденное завершение по пассивности одного из игроков
 *        начало игры
 * 
 * -- контроль пули
 *    раздача
 *    назначение первого на торг
 *
 * @author Евгений Версоцкий
 * @access   public
 * @package  Cu
 * @version  0.1alpha
 */
class Cu
{
    /**
     * static var for realize singlton
     * @var Cu
     */
    public static $Cu;
    
    /**
     * response stack
     * @var array
     */
    public $response = array(
                              // actions (addMessage, addError, eval etc.)
                              'a' => array(),
                              // jqueries
                              'q' => array()
                            );
    /**
     * __construct
     *
     * @access  public
     */
    function __construct() 
    {
    	
    }
    
    /**
     * init
     * init singleton if needed
     *
     * @return void
     */
    public static function init()
    {
        if (empty(Cu::$Cu)) {
            Cu::$Cu = new Cu();
        }
        return true;
    }


    /**
     * addData
     *
     * add any data to response
     *
     * @param string $key
     * @param mixed $value
     * @param string $callBack
     * @return Jquery
     */
    public static function addData ($key, $value, $callBack = null)
    {
        Jquery::init();

        $Jquery_Action = new Jquery_Action();
        $Jquery_Action ->add('k', $key);
        $Jquery_Action ->add('v', $value);
        
        // add call back func into response JSON obj
        if ($callBack) {
            $Jquery_Action ->add("callback", $callBack);
        }

        Jquery::addAction(__FUNCTION__, $Jquery_Action);

        return Jquery::$Jquery;
    }

    /**
     * addMessage
     * 
     * @param string $msg
     * @param string $callBack
     * @param array  $params
     * @return Jquery
     */
    public static function addMessage ($msg, $callBack = null, $params = null)
    {
        Jquery::init();
        
        $Jquery_Action = new Jquery_Action();        
        $Jquery_Action ->add("msg", $msg);
        
        
        // add call back func into response JSON obj
        if ($callBack) {
            $Jquery_Action ->add("callback", $callBack);
        }
        
        if ($params) {
            $Jquery_Action ->add("params",  $params);
        }
        
        Jquery::addAction(__FUNCTION__, $Jquery_Action);
        
        return Jquery::$Jquery;
    }
    
    /**
     * addError
     * 
     * @param string $msg
     * @param string $callBack
     * @param array  $params
     * @return Jquery
     */
    public static function addError ($msg, $callBack = null, $params = null)
    {
        Jquery::init();
        
        $Jquery_Action = new Jquery_Action();        
        $Jquery_Action ->add("msg", $msg);

        // add call back func into response JSON obj
        if ($callBack) {
            $Jquery_Action ->add("callback", $callBack);
        }
        
        if ($params) {
            $Jquery_Action ->add("params",  $params);
        }
        
        Jquery::addAction(__FUNCTION__, $Jquery_Action);
        
        return Jquery::$Jquery;
    }
    /**
     * evalScript
     *      
     * @param  string $foo
     * @return Jquery
     */
    public static function evalScript ($foo)
    {
        Jquery::init();
        
        $Jquery_Action = new Jquery_Action();        
        $Jquery_Action ->add("foo", $foo);

        Jquery::addAction(__FUNCTION__, $Jquery_Action);
        
        return Jquery::$Jquery;
    }
    
    /**
     * response
     * init singleton if needed
     *
     * @return string JSON
     */
    public static function getResponse()
    {
        Jquery::init();
        
        echo json_encode(Jquery::$Jquery->response);
        exit ();
    }
    
    /**
     * addQuery
     * add query to stack
     *
     * @return Jquery_Element
     */
    public static function addQuery($selector)
    {
        Jquery::init();
        
        return new Jquery_Element($selector);
    }
    
    /**
     * addQuery
     * add query to stack
     * 
     * @param  Jquery_Element $Jquery_Element
     * @return void
     */
    public static function addElement(Jquery_Element &$Jquery_Element)
    {
        Jquery::init();
        
        array_push(Jquery::$Jquery->response['q'], $Jquery_Element);
    }
    
        
    /**
     * addAction
     * add query to stack
     * 
     * @param  string $name
     * @param  Jquery_Action $Jquery_Action
     * @return void
     */
    public static function addAction($name, Jquery_Action &$Jquery_Action)
    {
        Jquery::init();
        
        Jquery::$Jquery->response['a'][$name][] = $Jquery_Action;
    }
}

/**
 * Jquery
 *
 * alias for Jquery::Jquery
 *
 * @access  public
 * @param   string   $selector
 * @return  Jquery_Element
 */
function Jquery($selector) 
{
    return Jquery::addQuery($selector);
}