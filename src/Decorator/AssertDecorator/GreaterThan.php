<?php

namespace Er1z\FakeMock\Decorator\AssertDecorator;

class GreaterThan extends GreaterThanOrEqual
{
    protected function useTrailer()
    {
        return true;
    }
}
