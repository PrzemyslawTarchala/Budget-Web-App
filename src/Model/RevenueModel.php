<?php

declare(strict_types=1);

namespace App\Model;

require_once("src/Model/AbstractModel.php");

use App\Model\AbstractModel;

class RevenueModel extends AbstractModel
{
	public function addRevenue(array $revenueData)
	{
		echo('Revenue Model');
		exit();
	}
}