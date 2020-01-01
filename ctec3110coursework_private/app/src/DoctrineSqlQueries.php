<?php


namespace M2MAPP;


class DoctrineSqlQueries
{
    public function __construct(){}

    public function __destruct(){}

    public static function queryStoreUserData($queryBuilder, array $cleaned_parameters, string $hashed_password)
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

    public static function queryRetrieveUserData()
    {
        $sql_query_string = '';
        return $sql_query_string;
    }
}