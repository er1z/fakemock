<?php

namespace Er1z\FakeMock\Decorator\AssertDecorator;

class LessThan extends LessThanOrEqual
{
    protected function useTrailer()
    {
        return true;
    }
}
