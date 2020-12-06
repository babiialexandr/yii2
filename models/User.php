<?php

namespace app\models;

use dektrium\user\models\User as DektriumUserModel;

class User extends DektriumUserModel
{
    const ROLE_ADMIN = 1;

    const ROLE_USER = 2;

    public static $mapRoles = [
        self::ROLE_ADMIN => 'admin',
        self::ROLE_USER => 'user'
    ];

    /**
     * @inheritdoc
     *
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['create'][] = 'role';
        $scenarios['update'][] = 'role';
        return $scenarios;
    }

    /**
     * @inheritdoc
     *
     * @return array
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules['fieldRequired'] = ['role', 'required', 'on' => ['update']];
        return $rules;
    }
}
