<?php

namespace M2MAPP;

class SQLQueries
{
    public function __construct() { }

    public function __destruct() { }

    /*

    public function getAllCompanySymbols()
    {
        $query_string  = "SELECT stock_company_symbol, stock_company_name ";
        $query_string .= "FROM company_name ";
        $query_string .= "ORDER BY stock_company_name";
        return $query_string;
    }

    public function getCompanyStockData()
    {
        $query_string  = "SELECT stock_last_value, stock_date, stock_time, stock_company_name ";
        $query_string .= "FROM company_name, stock_data ";
        $query_string .= "WHERE company_name.stock_company_symbol = :stock_company_symbol ";
        $query_string .= "AND company_name.stock_company_name_id = stock_data.fk_company_stock_id ";
        $query_string .= "ORDER BY stock_date";
        return $query_string;
    }
    public function checkCompanySymbol()
    {
        $query_string  = "SELECT stock_company_symbol, stock_company_name_id ";
        $query_string .= "FROM sq_company_name ";
        $query_string .= "WHERE stock_company_symbol = :stock_company_symbol ";
        $query_string .= "LIMIT 1";
        return $query_string;
    }

    public function storeCompanyName()
    {
        $query_string  = "INSERT INTO sq_company_name ";
        $query_string .= "SET ";
        $query_string .= "stock_company_symbol = :stock_company_symbol, ";
        $query_string .= "stock_company_name = :stock_company_name;";
        return $query_string;
    }

    public function getCompanyDetails()
    {
        $query_string  = "SELECT stock_company_name_id, stock_company_symbol, stock_company_name ";
        $query_string .= "FROM sq_company_name;";
        return $query_string;
    }

    public function checkCompanyExists()
    {
        $query_string  = "SELECT stock_company_name_id ";
        $query_string .= "FROM sq_company_name, sq_stock_data ";
        $query_string .= "WHERE sq_company_name.stock_company_symbol = :stock_company_symbol ";
        $query_string .= "AND sq_company_name.stock_company_name_id = sq_stock_data.fk_company_stock_id ";
        $query_string .= "AND stock_date = :stock_date ";
        $query_string .= "AND stock_time = :stock_time ";
        $query_string .= "LIMIT 1";
        return $query_string;
    }

    public function storeCompanyStockData()
    {
        $query_string  = "INSERT INTO sq_stock_data ";
        $query_string .= "SET ";
        $query_string .= "stock_date = :stock_date, ";
        $query_string .= "stock_time = :stock_time, ";
        $query_string .= "stock_last_value = :stock_last_value, ";
        $query_string .= "fk_company_stock_id = :fk_company_stock_id;";
        return $query_string;
    }


    */
}
