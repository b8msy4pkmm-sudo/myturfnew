<?php
namespace MAIN_NAMESPACE\models\sqlReq;

use MAIN_NAMESPACE\datas\AccessDB;
use MAIN_NAMESPACE\utilities\toolbox\toolbox;
require_once("./models/Main.Model.Class.php");
require_once("./controllers/utilities/toolbox/Toolbox.Class.php");


class SqlModel extends AccessDB 
{
    public function getOneRowDatasFromTable(string $table, array $datasConditions)
    {
        $req  = "SELECT * FROM $table ";
        if (count($datasConditions)>0)
        {
            $req .= " WHERE ";
            $req .= $this -> querySequelBuilt('AND',$datasConditions);
        }
        $stmt = $this->getBdd()->prepare($req);
        $this->queryStmtBuilt($stmt,$datasConditions);
        $stmt -> execute();
        $resultat=$stmt->fetch(\PDO::FETCH_ASSOC);
        $stmt -> closeCursor();
        return $resultat;
    }
    public function getFewRowsDatasFromTable(string $table, array $datasConditions,array $orderBy)
    {
        $req  = "SELECT * FROM $table ";
        if (count($datasConditions)>0)
        {
            $req .= " WHERE ";
            $req .= $this->querySequelBuilt('AND', $datasConditions);
        }
        if(count($orderBy)>0)$req .= " ORDER BY $orderBy[0] $orderBy[1] ";
        $stmt = $this->getBdd()->prepare($req);
        $this->queryStmtBuilt($stmt,$datasConditions);
        $stmt -> execute();
        $resultat=$stmt->fetchAll(\PDO::FETCH_ASSOC);
        $stmt -> closeCursor();
        return $resultat;
    }
    public function getWithJoinDatasFrom2Tables(array $elementTable_1,array $elementTable_2,array $datasConditions,array $orderBy)
    {
        $req  ="SELECT ";
        $req .= $this->startQueryJoin($elementTable_1);
        $req .= (count($elementTable_2['columnHeader'])>0)?", ":"";
        $req .= $this->startQueryJoin($elementTable_2);
        $req .= " FROM ".$elementTable_1['nameOfTable'];
        $req .= " INNER JOIN ";
        $req .= $elementTable_2['nameOfTable'];
        $req .= " ON ";
        $req .= $elementTable_1['nameOfTable'].'.'.$elementTable_1['keyForJoin'];
        $req .= " = ";
        $req .= $elementTable_2['nameOfTable'].'.'.$elementTable_2['keyForJoin'];
        if (count($datasConditions)>0)
        {
            $req .= " WHERE ";
            $req .= $this->querySequelBuilt('AND', $datasConditions);
        }
        if (count($orderBy)>0)$req .= " ORDER BY ";
        if (count($orderBy)===2) $req.= "$orderBy[0] $orderBy[1] ";
        if (count($orderBy)===4) $req.= "$orderBy[0] $orderBy[1],  $orderBy[2] $orderBy[3]";
        $stmt = $this->getBdd()->prepare($req);
        $this->queryStmtBuilt($stmt,$datasConditions);
        $stmt -> execute();
        $resultat=$stmt->fetchAll(\PDO::FETCH_ASSOC);
        $stmt -> closeCursor();
        return $resultat;
    }

    public function getWithJoinDatasFrom3Tables(array $elementTable_1,array $elementTable_2,array $elementTable_3,array $datasConditions,array $orderBy)
    {
        $req  ="SELECT ";
        $req .= $this->startQueryJoin($elementTable_1);
        $req .= (count($elementTable_2['columnHeader'])>0)?", ":"";
        $req .= $this->startQueryJoin($elementTable_2);
        $req .= (count($elementTable_3['columnHeader'])>0)?", ":"";
        $req .= $this->startQueryJoin($elementTable_3);
        $req .= " FROM ".$elementTable_1['nameOfTable'];
        $req .= " INNER JOIN ";
        $req .= $elementTable_2['nameOfTable'];
        $req .= " ON ";
        $req .= $elementTable_1['nameOfTable'].'.'.$elementTable_1['keyForJoin'];
        $req .= " = ";
        $req .= $elementTable_2['nameOfTable'].'.'.$elementTable_2['keyForJoin'];
        $req .= " INNER JOIN ";
        $req .= $elementTable_3['nameOfTable'];
        $req .= " ON ";
        $req .= $elementTable_3['nameOfTable'].'.'.$elementTable_3['keyForJoin'];
        $req .= " = ";
        $req .= $elementTable_1['nameOfTable'].'.'.$elementTable_1['keyForJoin'];
        if (count($datasConditions)>0)
        {
            $req .= " WHERE ";
            $req .= $this->querySequelBuilt('AND', $datasConditions);
        }
        if (count($orderBy)>0)$req .= " ORDER BY ";
        if (count($orderBy)===2) $req.= "$orderBy[0] $orderBy[1] ";
        if (count($orderBy)===4) $req.= "$orderBy[0] $orderBy[1],  $orderBy[2] $orderBy[3]";
        $stmt = $this->getBdd()->prepare($req);
        $this->queryStmtBuilt($stmt,$datasConditions);
        $stmt -> execute();
        $resultat=$stmt->fetchAll(\PDO::FETCH_ASSOC);
        $stmt -> closeCursor();
        return $resultat;
    }
    public function insertOneRowInDataTable(string $table, array $datasToInsert)
    {
        $req   = "INSERT INTO $table (";
        $req  .= $this->insertSequelBeforeValue(',',$datasToInsert);
        $req  .= ") VALUES (";
        $req  .= $this->insertSequelAfterValue(',',$datasToInsert);
        $req  .= ")";
        $stmt  = $this -> getBdd() -> prepare($req);
        $this->queryStmtBuilt($stmt,$datasToInsert);
        $stmt -> execute();
        $estModifier = ($stmt -> rowCount() > 0);
        $stmt -> closeCursor();
        return $estModifier;
    }
    public function deleteRowFromDataTable(string $table, array $datasConditions):int
    {
        $req  = "DELETE FROM $table ";
        $req .= " WHERE ";
        $req .= $this -> querySequelBuilt('AND',$datasConditions);
        //Toolbox::addMessageAlert($req,Toolbox::COLOR_WARNING);
        $stmt = $this->getBdd()->prepare($req);
        //$stmt -> bindValue(":id",$id,\PDO::PARAM_INT);
        $this->queryStmtBuilt($stmt,$datasConditions);
        $stmt -> execute();
        $isDeleted = ($stmt -> rowCount() > 0);
        $stmt -> closeCursor();
        return (int)$isDeleted;
    }
    public function updateDatasInDataTable(string $table, array $datasToUdapte, array $datasConditions):int
    {
        $req  = "UPDATE $table SET ";
        $req .= $this->querySequelBuilt(',',$datasToUdapte);
        $req .= " WHERE ";
        $req .= $this->querySequelBuilt('AND', $datasConditions);
        //Toolbox::addMessageAlert($req,Toolbox::COLOR_WARNING);
        $stmt = $this->getBdd()->prepare($req);
        $this->queryStmtBuilt($stmt,$datasToUdapte);
        $this->queryStmtBuilt($stmt,$datasConditions);
        $stmt -> execute();
        $isModifed = ($stmt -> rowCount() > 0);
        $stmt -> closeCursor();
        return (int)$isModifed;
    }
    private function querySequelBuilt(string $mainSymbol, array $allQueryConditions):string
    {
        $req="";
        $nbDatas=count($allQueryConditions);
        foreach ($allQueryConditions as $index => $queryConditions) 
        {
            if(is_array($queryConditions))
            {
                $req.="(";
                ($nbDatas>1)?$sequel=" $mainSymbol ":$sequel="";
                $signe=array_shift($queryConditions);
                $nbDatas1=count($queryConditions);
                $key=0;
                for ($i=0;$i<count($queryConditions);$i++)
                { 
                    switch ($signe)
                    {
                        case '=': $req.= $index. " $signe :$index$i"; $otherSymbol="OR";
                        break;
                        case '>' :
                        case '>=':
                        case '<':
                        case '<=':
                            $req.= $index. " $signe :$index$i";
                        break;
                        case '<>':
                            $req.= $index. " $signe :$index$i";$otherSymbol="AND";
                        break;
                        case '><':
                            if($key==0)
                            {
                                $newSigne=">=";
                                $key++;
                            }else
                            {
                                $newSigne="<=";
                                $key--;
                            }
                            $req.= $index. " $newSigne :$index$i";$otherSymbol="AND";
                        break;
                        default:
                            $req.= "";
                        break;
                    };             
                    ($nbDatas1>1)?$newSequel= " $otherSymbol ":$newSequel=")";
                    $req.=$newSequel;
                    $nbDatas1--;
                }
                $req.= " $sequel ";
            }
            else
            {
                $querySequel = ($nbDatas>1)?" $mainSymbol ":"";
                // if(strpos($index,'.'))
                // {
                //     $ch3=explode('.',$index);
                //     $ch4=$ch3[1];
                //     //toolbox::addMessageAlert("ch4 : ".$ch4,toolbox::COLOR_WARNING);
                //     $req.= $index.' = :'.$ch4.$querySequel;
                // }
                // else
                // {
                //     $req.= $index.' = :'.$index.$querySequel;
                // }
                $req.= $index.' = :'.$index.$querySequel;
                }
            $nbDatas--;
        }
        return $req;
    }
    private function insertSequelBeforeValue(string $char, array $datas):string
    {
        $req="";
        $nbDatas=count($datas);
        foreach ($datas as $index => $value) 
        {
            $querySequel = ($nbDatas>1)?"$char ":"";
            $req .= $index.$querySequel;
            $nbDatas--;
        }
        return $req;
    }   
    private function insertSequelAfterValue(string $char, array $datas):string
    {
        $req="";
        $nbDatas=count($datas);
        foreach ($datas as $index => $value) 
        {
            $querySequel = ($nbDatas>1)?"$char ":"";
            $req .=  ':'.$index.$querySequel;
            $nbDatas--;
        }
        return $req;
    }

    private function queryStmtBuilt(object $stmt, array $allQueryConditions)
    {
        foreach ($allQueryConditions as $index => $queryConditions) 
        {
            if(is_array($queryConditions))
            {
                array_shift($queryConditions);
                for ($i=0;$i<count($queryConditions);$i++)
                {
                    if (is_numeric($queryConditions)){
                        if (is_float($queryConditions))
                        {
                            $pdo=\PDO::PARAM_STR;
                        }else{
                            $pdo=\PDO::PARAM_INT;
                        }
                    }else
                    {
                        $pdo=\PDO::PARAM_STR;
                    }
                    $stmt -> bindValue(":".$index.$i, $queryConditions[$i], $pdo);
                }
            }
            else
            {
                if (is_numeric($queryConditions))
                {
                    if (is_float($queryConditions))
                    {
                        $pdo=\PDO::PARAM_STR;
                    }else{
                        $pdo=\PDO::PARAM_INT;
                    }
                }else
                {
                    $pdo=\PDO::PARAM_STR;
                }
                $stmt -> bindValue(":".$index, $queryConditions, $pdo);
            }
        }
    } 

    private function startQueryJoin(array $elementTable):string
    {
        $req="";
        for ($i=0; $i < count($elementTable['columnHeader']); $i++) { 
            (count($elementTable['columnHeader'])==1 || $i==(count($elementTable['columnHeader'])-1))?$symbol='':$symbol=', ';
            // (count($elementTable['columnHeader'])==1)?$symbol='':$symbol=', ';
            $req.=$elementTable['nameOfTable'].'.'.$elementTable['columnHeader'][$i].$symbol;
        }
        return $req;
    }


}
