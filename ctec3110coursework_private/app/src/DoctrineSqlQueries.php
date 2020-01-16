<?php


namespace M2MAPP;


class DoctrineSqlQueries
{
    public function __construct(){}

    public function __destruct(){}

    /**
     * @param $queryBuilder
     * @param array $cleaned_parameters
     * @param string $hashed_password
     * @return array
     */

    public static function queryStoreUserData($queryBuilder, $cleaned_parameters, $hashed_password)
    {
        $store_result = [];
        $username = $cleaned_parameters['sanitised_username'];
        $email = $cleaned_parameters['sanitised_email'];

        $queryBuilder = $queryBuilder->insert('user_data')
            ->values([
                'user_name' => ':name',
                'email' => ':email',
                'password' => ':password',
            ])
            ->setParameters([
                ':name' => $username,
                ':email' => $email,
                ':password' => $hashed_password
            ]);

        $store_result['outcome'] = $queryBuilder->execute();
        $store_result['sql_query'] = $queryBuilder->getSQL();

        return $store_result;
    }
}