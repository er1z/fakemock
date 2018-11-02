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

        throw new \InvalidArgumentException(sprintf('Annotation %s not found in collection', $class));
    }

    public function findOneBy($class)
    {
        $result = array_values($this->findAllBy($class))[0] ?: null;
        return $result;
    }

    public function findAllBy($class){
        return array_filter($this->annotations, function($a) use ($class){
            return $a instanceof $class;
        });
    }

}