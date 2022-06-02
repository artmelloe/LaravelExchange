<?php

namespace Tests\Unit;

use App\Models\Configuration;
use PHPUnit\Framework\TestCase;

class ConfigurationTest extends TestCase
{
    public function test_types()
    {
        $configuration = new Configuration();

        $configuration->boleto_fee = 1.45;
        $configuration->credit_card_fee = 7.63;
        $configuration->fee_amount_less = 2;
        $configuration->fee_amount_less_value = 3000;
        $configuration->fee_amount_greater = 1;
        $configuration->fee_amount_greater_value = 3000;

        $this->assertThat($configuration->boleto_fee, $this->logicalOr(
            $this->isType('int'),
            $this->isType('float')
        ));
        $this->assertThat($configuration->credit_card_fee, $this->logicalOr(
            $this->isType('int'),
            $this->isType('float')
        ));
        $this->assertThat($configuration->fee_amount_less, $this->logicalOr(
            $this->isType('int'),
            $this->isType('float')
        ));
        $this->assertIsInt($configuration->fee_amount_less_value);
        $this->assertThat($configuration->fee_amount_greater, $this->logicalOr(
            $this->isType('int'),
            $this->isType('float')
        ));
        $this->assertIsInt($configuration->fee_amount_greater_value);
    }
}
