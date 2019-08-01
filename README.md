[![Build Status](https://travis-ci.com/moreonion/payment_recurrence.svg?branch=7.x-1.x)](https://travis-ci.com/moreonion/payment_recurrence) [![codecov](https://codecov.io/gh/moreonion/payment_recurrence/branch/7.x-1.x/graph/badge.svg)](https://codecov.io/gh/moreonion/payment_recurrence)

# Payment recurrence

This is a Drupal module that extends the [payment module](https://www.drupal.org/project/payment) by adding a standardized way to specify recurrency on payment line items.

*This is a utility module. If no other module you want to have installed requires this you won’t need it.*


## Requirements

* Drupal 7.x
* [payment](https://www.drupal.org/project/payment)


## Usage

With this module enabled each payment line item can optionally have an additional attribute `recurrence`. This attribute is again an object having with the following attributes:

- `interval_unit` (str): String with up to 16 characters describing the base interval. Usual values are `yearly`, `monthly`, `weekly`. If this is empty the line item is being interpreted as one-time.
- `interval_value` (int): An integer signifying the multiple of the `interval_unit` (ie. `interval_unit = 'monthly'` and `interval_value = 3` means quarterly). Defaults to `1`.
- `day_of_month` (int): Day of month when payments should be made (usually used for monthly payments). Usually defaults to the earliest possible day.
- `month` (int): Month when the payment should be made (usually used for yearly payments). Usually defaults to the earliest possible month.
- `start_date` (date): Payments should start on this date at the earliest. Defaults to the earliest possible date.
- `count` (int): Stop the recurrence after `count` payments were made. An emtpy value means that the recurrence should go on indefinitely.


## Payment methods that using this

*Please open a documentation bug if a payment method is missing here*

* [gocardless](https://www.drupal.org/project/gocardless_payment)


## Rationale

### Why is this based on line items not on payments?

Some use-cases require a one-time payments in addition recurrent payments. Having the possibility to have line items with mixed recurrence means such a transaction can be processed as a single payment.

### How does this compare to [payment recurring](https://www.drupal.org/project/payment_recurring)?

[Payment recurring](https://www.drupal.org/project/payment_recurring) assumes that Drupal should be responsible for keeping track of all the single payments made for ongoing payments while [payment recurrence](https://www.drupal.org/project/payment_recurring) assumes the payment methods themselves can handle that.

