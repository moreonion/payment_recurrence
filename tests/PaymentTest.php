<?php

namespace Drupal\payment_recurrence;

use Upal\DrupalUnitTestCase;

/**
 * Test loading and saving payments.
 */
class PaymentTest extends DrupalUnitTestCase {

  /**
   * Create a test payment.
   */
  public function setUp(): void {
    parent::setUp();
    $this->payment = new \Payment([
      'description' => 'gocardless test payment',
      'currency_code' => 'EUR',
      'method' => new \PaymentMethod(),
      'contextObj' => NULL,
    ]);
    $this->payment->setLineItem(new \PaymentLineItem([
      'name' => 'test',
    ]));
  }

  /**
   * Remove the test payment.
   */
  public function tearDown(): void {
    if ($this->payment->pid) {
      entity_delete('payment', $this->payment->pid);
    }
    parent::tearDown();
  }

  /**
   * Test that after saving then loading a payment the attributes are present.
   */
  public function testEmptyFieldsAreLoaded() {
    entity_save('payment', $this->payment);
    $payment = entity_load_single('payment', $this->payment->pid);
    $line_item = $payment->line_items['test'];
    $this->assertObjectNotHasAttribute('recurrence', $line_item);
  }

  /**
   * Test that saving values for the custom fields works.
   */
  public function testSaveLoad() {
    $line_item = $this->payment->line_items['test'];
    $line_item->recurrence = (object) [
      'interval_unit' => 'yearly',
      'interval_value' => 1,
      'month' => 10,
      'day_of_month' => 15,
      'start_date' => new \DateTime('tomorrow', new \DateTimeZone('UTC')),
      'count' => 5,
    ];
    entity_save('payment', $this->payment);

    $payment = entity_load_single('payment', $this->payment->pid);
    $new_line_item = $payment->line_items['test'];

    foreach (((array) $line_item->recurrence) as $field => $value) {
      $this->assertEqual($value, $new_line_item->recurrence->$field);
    }
  }

}
