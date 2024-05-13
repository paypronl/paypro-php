<?php

namespace PayPro\Entities;

use PayPro\Exception\ApiErrorException;
use PayPro\Operations\Request;

class InstallmentPlanPeriod extends Resource
{
    use Request;

    public function resourcePath()
    {
        return 'installment_plan_periods';
    }

    /**
     * Returns all payments of the installment plan period.
     *
     * @param mixed $params
     *
     * @return Collection of a list with the payments
     *
     * @throws ApiErrorException if the request fails
     */
    public function payments($params = [])
    {
        $url = $this->resourceUrl() . '/payments';

        return $this->apiRequest('get', $url, $params);
    }
}
