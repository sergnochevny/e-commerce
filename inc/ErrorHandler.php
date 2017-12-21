<?php
/**
 * Date: 20.12.2017
 * Time: 10:14
 */

namespace inc;

use app\core\App;
use app\core\ErrorHandlerInterface;
use controllers\base\ControllerMain;

/**
 * Class ErrorHandler
 * @package inc
 */
class ErrorHandler implements ErrorHandlerInterface{

  /**
   * @var \Exception
   */
  private $exception;

  /**
   * ErrorHandler constructor.
   * @param null $excetion
   */
  public function __construct($excetion = null){
    $this->exception = $excetion;
  }

  /**
   * @return mixed
   * @throws \Exception
   */
  public function handle(){

    if(!empty($this->exception) && !empty($message = $this->exception->getMessage())) {
      return (new ControllerMain(App::$app->router()->controllerObj))->error404();
    }

    return (new ControllerMain())->error404();
  }
}