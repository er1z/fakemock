<?php


namespace Er1z\FakeMock\Annotations;
use Doctrine\Common\Annotations\Annotation;

/**
 * Class FakeAnnotation
 * @Annotation()
 */
class FakeMockField
{

    /**
     * @var string
     */
    public $method = null;

    /**
     * @var null|string
     */
    public $options = null;

    /**
     * @var bool
     */
    public $recursive = true;

    /**
     * @var null|string[]
     */
    public $groups = null;

    public function __construct($data)
    {

        if(is_array($data)){
            foreach($data as $k=>$v){
                $this->$k = $v;
            }
        }else{
            $this->method = $data;
        }

        return;
    }

}
