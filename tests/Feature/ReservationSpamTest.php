<?php

namespace Tests\Feature;

use Spatie\Honeypot\EncryptedTime;
use Tests\TestCase;

class ReservationSpamTest extends TestCase
{
    /** @test */
    public function it_is_a_spam_without_honeypot()
    {
        $this->post('reservation')
            ->assertStatus(400);
    }

    /** @test */
    public function it_is_a_spam_if_honeypost_has_any_value()
    {
        $this->post('reservation', [
            'matsu_honeypot' => 'some value',
        ])->assertStatus(400);
    }

    /** @test */
    public function it_is_a_spam_if_time_value_is_invalid()
    {
        $this->post('reservation', [
            'matsu_honeypot' => null,
            'encrypted_time' => 'invalid time',
        ])->assertStatus(400);
    }

    /** @test */
    public function it_is_a_spam_if_creating_a_reservation_takes_a_very_short_time()
    {
        $this->post('reservation', [
            'matsu_honeypot' => null,
            'encrypted_time' => EncryptedTime::create(now()->addSecond())->__toString(),
        ])->assertStatus(400);
    }
}
