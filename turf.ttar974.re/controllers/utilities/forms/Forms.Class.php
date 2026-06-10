<?php

namespace MAIN_NAMESPACE\utilities\form;

use MAIN_NAMESPACE\utilities\toolbox\Toolbox;

class Form
{
    /**
     * createInput
     *
     * @param  mixed $class
     * @param  mixed $type (text, password, email, number,...)
     * @param  mixed $name (name et id)
     * @param  mixed $formInputValue
     * @param  mixed $placeholder
     * @param  mixed $option (required et autres attributs)
     * @return string
     */
    public static function createInput(string $class, string $type, string $name, string $formInputValue, string $placeholder, string $option):string
    {
        $classInput= $class!==""?"class='".htmlspecialchars($class,ENT_QUOTES)."'":'';
        $attributes= $option!==''? $option:'';
        $safeName        = htmlspecialchars($name, ENT_QUOTES);
        $safeValue       = htmlspecialchars($formInputValue, ENT_QUOTES);
        $safePlaceholder = htmlspecialchars($placeholder, ENT_QUOTES);
        return "<input type='$type' $classInput name='$safeName' id='$safeName' value='$safeValue' placeholder='$safePlaceholder' $attributes>";
    }

    /**
     * createSelect
     *
     * @param  mixed $class
     * @param  mixed $name
     * @param  mixed $formOptionvalue // Valeur de l'option renvoyée ou reçue
     * @param  mixed $datasValues     // tableau de données représentent chaque value de option. Si vide value sera rempli par $datasList
     * @param  mixed $datasList       // Tableau de données qui constituent la liste déroulante
     * @param  mixed $option
     * @return string
     */
    public static function createSelect(string $class, string $name, $formOptionValue, array $datasValues, array $datasList,string $option): string 
    {
        $html_options = [];
        $i=0;
        foreach($datasValues as $dataValue){
            $attributes = $dataValue == $formOptionValue ?' selected':'';
            if(count($datasValues)>0){
                $html_options[] = "<option value='$dataValue' $attributes>$datasList[$i]</option>";
            }
            else
            {
                $html_options[] = "<option value='$dataValue' $attributes>$datasList[$i]</option>";
            }
            $i++;
        }
        $class!==""?($class="class='$class'"):"";
        return "<select $class id=$name name=$name $option>".implode($html_options)."</select>";
    }

    public static function createRadioList(string $classUl, string $classLi, string $name, $formRadioValue, array $datasValue, array $datasList):string
    {
        $html_radio=[];
        $classNameLi=$classLi!=""?"class='$classLi'":"";
        $classNameUl=$classUl!=""?"class='$classUl'":"";
        $counter=0;
        foreach ($datasValue as $value) {
            $attributes=($value===$formRadioValue)?$attributes='checked':'';
            $html_radio[]="<li $classNameLi>
            <input type='radio' id='$name"."_$counter' name='$name' value='$value' $attributes/>
            <label for='$name"."_$counter'>$datasList[$counter]</label>
            </li>";
            $counter++;
        }
        return "<ul $classNameUl>".implode($html_radio)."</ul>";
    }

    /**
     * createCheckboxList
     *
     * @param  mixed $classUl
     * @param  mixed $classLi
     * @param  mixed $name
     * @param  mixed $formCheckboxValues
     * @param  mixed $datas
     * @return string
     */
    public static function createCheckboxList(string $classUl,string $classLi, string $name, array $formCheckboxValues, array $datasValue, array $datasList):string
    {
        $html_checkbox=[];
        $attributes="";
        $classNameLi=$classLi!=""?"class='$classLi'":"";
        $classNameUl=$classUl!=""?"class='$classUl'":"";
        $counter=0;
        foreach ($datasValue as $value) { 
            $attributes=in_array($value,$formCheckboxValues)?"checked":"";
            $html_checkbox[]="<li $classNameLi><input  type='checkbox' id='$name"."_$counter' name='{$name}[]' value='$value' $attributes/>
            <label for='$name"."_$counter'>".ucfirst($datasList[$counter])."</label></li>";
            $counter++;
        }
        return "<ul $classNameUl>".implode($html_checkbox)."</ul>";
    }
    
    /**
     * createTextarea
     *
     * @param  mixed $name
     * @param  mixed $comment
     * @return string
     */
    public static function createTextarea($name, $comment):string
    {
        $safeName    = htmlspecialchars($name, ENT_QUOTES);
        $safeComment = htmlspecialchars($comment, ENT_QUOTES);
        return "<textarea name='$safeName' placeholder='Un commentaire !' id='$safeName'>$safeComment</textarea>";
    }
}