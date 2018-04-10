<?
function CheckUserCount(){
	if (CModule::IncludeModule('main'))
	{
		//get time
		$time_old = COption::GetOptionInt('main', 'my_calc_users');
		$time_new=time();

		COption::SetOptionInt('main', 'my_calc_users', $time_new);

		if (!$time_old)
			return 'CheckUserCount();';

		//calc days
		$days = intval(($time_new - $time_old) / 86400);

		//get users
		$by='date_register';
		$order='desc';
		$filter=['TIMESTAMP_1' => ConvertTimeStamp($time_old,'FULL')];
		$select=['FIELDS'=>['DATE_REGISTER']];
		$Res=CUser::GetList($by,$order,$filter,$select);

		//check register date
		$count=0;
		while ($user=$Res->Fetch())
			if (MakeTimeStamp($user['DATE_REGISTER'])>$time_old)
				$count++;

		if (!$count)
			return 'CheckUserCount();';

		//send mail
		$arEventFields = array('COUNT' => $count,
		                       'DAYS'  => $days);
		CEvent::Send("NEW_REGS_USERS", SITE_ID, $arEventFields);
	}

	return 'CheckUserCount();';
}