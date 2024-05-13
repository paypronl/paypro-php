<?php

namespace PayPro\Entities;

use PayPro\Exception\ApiErrorException;
use PayPro\Operations\Request;
use PayPro\Operations\Update;

class InstallmentPlan extends Resource
{
    use Request;
    use Update;

    public function resourcePath()
    {
        return 'installment_plans';
    }

    /**
     * Cancels the installment plan.
     *
     * @return static the canceled installment plan
     *
     * @throws ApiErrorException if the request fails
     */
    public function cancel()
    {
        return $this->apiRequest('delete', $this->resourceUrl());
    }

    /**
     * Pauses the installment plan.
     *
     * @return static the paused installment plan
     *
     * @throws ApiErrorException if the request fails
     */
    public function pause()
    {
        $url = $this->resourceUrl() . '/pause';

        return $this->apiRequest('post', $url);
    }

    /**
     * Resumes the installment plan.
     *
     * @return static the resumed installment plan
     *
     * @throws ApiErrorException if the request fails
     */
    public function resume()
    {
        $url = $this->resourceUrl() . '/resume';

        return $this->apiRequest('post', $url);
    }

    /**
     * Returns all installment plan periods of the installment plan.
     *
     * @param mixed $params
     *
     * @return Collection a list with the installment periods
     *
     * @throws ApiErrorException if the request fails
     */
    public function installmentPlanPeriods($params = [])
    {
        $url = $this->resourceUrl() . '/installment_plan_periods';

        return $this->apiRequest('get', $url, $params);
    }
}
