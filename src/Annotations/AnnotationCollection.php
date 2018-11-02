<?php


namespace Er1z\FakeMock\Annotations;


class AnnotationCollection
{

    /**
     * @var array
     */
    private $annotations;

    public function __construct($annotations = [])
    {
        $this->annotations = $annotations;
    }

    public function getOneBy($class)
    {
        if($result = $this->findOneBy($class)){
            return $result;
        }

        throw new \InvalidArgumentException(sprintf('Annotation %s not found in collection'));
    }

    public function findOneBy($class)
    {
        foreach($this->annotations as $a){
            if($a instanceof $class){
                return $a;
            }
        }
    }

    public function getAllBy($class){
        return array_filter($this->annotations, function($a) use ($class){
            return $a instanceof $class;
        });
    }

}