<?php

namespace Jh\Shipping;

use Jh\ShippingTest;

/**
 * Class ShippingDates
 * @package Jh\Shipping
 */
class ShippingDatesAdvanced implements ShippingDatesInterface
{
  /**
  *    Calculate and return delivery date for the order date placed
  *    @param \DateTime $orderDate
  *    @return \DateTime
  */
  public function calculateDeliveryDate(\DateTime $orderDatePlaced)
  {
    /**
    *   Obtain the list of dates from a particular week
    *   detailing the list of dates
    */
    echo "SHIPPING DATES ADVANCED TEST",PHP_EOL;
    echo "----------------------------",PHP_EOL;

    /**
    *   Call the class ShippingDatesTest and the datesProvider method
    *   to return a multidimensional associated array of dates
    */
    $shippingTest = new ShippingTest\ShippingDatesAdvancedTest();
    $weekOrder = $shippingTest->datesProvider();

    foreach ($weekOrder as $dayOrder=>$dates) {

      $orderDate = $dates['orderDate'];
      $newOrderDate = new \DateTime($orderDate);

      /**
      *   If order placed is the exact order date on the system
      *   Check the time that the order was placed
      */
      if ($newOrderDate == $orderDatePlaced) {
        $timeOrdered = strtotime($newOrderDate->format('H:i'));
        $fivePM = strtotime("17:00");

        /**  Print out the day and date of the order */
        echo "($dayOrder $orderDate) - ";

        /**
        * Check whether the day is a working day by checking whether orders
        * have been made at the weekend or after 5pm during the week

        * Display the appropiate message in association to the requirements
        */
        if ($timeOrdered >= $fivePM ||
            strpos($dayOrder, 'saturday') !== false ||
            strpos($dayOrder, 'sunday') !== false ) {
          $msg = "Your order will be dispatched the next working day";
        }

        else {
          $msg = "Your order will be dispatched before 5pm today";
        }

        /** Print out and return the expected delivery date */
        $deliveryDate = $dates['deliveryDate'];
        echo "$msg. Expected delivery date: $deliveryDate",PHP_EOL;
        $deliveryDate = new \DateTime($deliveryDate);
        return $deliveryDate;
      }
    }

    /**
    *   If delivery date has not been found
    *   Return friendly error message
    */
    $errorMsg = "The order date is invalid";
    return $errorMsg;
  }
}

?>
