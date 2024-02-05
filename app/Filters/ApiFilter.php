<?php

namespace App\Filters;

use Illuminate\Http\Request;
use Psy\CodeCleaner\IssetPass;

class ApiFIlter {
    protected $safeParms = [];

    protected $columnMap = [];

    protected $operatorMap = [];

    public function transform(Request $request){
        $eloQuery = [];

        foreach($this->safeParms as $parm => $operators){
            $query = $request->query($parm);

            if(!isset($query)){
                continue;
            }

            $column = $this->columnMap[$parm] ?? $parm;

            foreach($operators as $operator){
                if(Isset($query[$operator])){
                    $eloQuery[] = [$column, $this->operatorMap[$operator],$query[$operator]];
                }
            }
        }

        return $eloQuery;
    }
}