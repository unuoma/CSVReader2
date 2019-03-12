<?php
/**
 * Created by PhpStorm.
 * User: unuoma
 * Date: 3/9/19
 * Time: 12:08 PM
 */
main::start("example.csv");

class main  {

    static public function start($filename) {

        $myrecords = csv::getRecords($filename);
        $table = html::generateTable($myrecords);
        print("<h2>My current inventory</h2>");
        print($table);


    }
}

class html{

    public static function generateTable($records) {
        $count = 0;
        $tablestring = '';
        $tablestring .= "<html><head> <!-- Latest compiled and minified CSS -->
        <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css\">
        <!-- jQuery library -->
        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js\"></script>
        <!-- Latest compiled JavaScript -->
        <script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js\"></script> </head><body><table class='table table-striped'>";
        foreach ($records as $record) {
            $array = $record->returnArray();
            $fields = array_keys($array);
            $values = array_values($array);
            if ($count == 0) {
                $tablestring .= '<thead class="table table-bordered"><tr>';
                $tablestring .= '<th scope = "col"></th>';
                foreach ($fields as $h) {
                    $tablestring .= '<th scope = "col">';
                    $tablestring .= $h;
                    $tablestring .= '</th>';
                }

                $tablestring .= '</tr></thead>';
                $tablestring .= '<tbody class="table table-bordered">';
            }
            $tablestring .= '<tr><th scope = "row">';
            foreach($values as $k){
                $tablestring .= '<td>';
                $tablestring .= $k;
                $tablestring .= '</td>';
            }
            $tablestring .= '</tr>';

            $count=1;
        }
        $tablestring .= '</tbody></table>';

        return $tablestring;
    }
}
class csv {


    static public function getRecords($filename) {

        $file = fopen($filename,"r");

        $fieldNames = array();

        $count = 0;


        while(! feof($file))
        {

            $record = fgetcsv($file);
            if($count == 0) {
                $fieldNames = $record;
            } else {
                $records[] = recordFactory::create($fieldNames, $record);
            }
            $count++;
        }

        fclose($file);
        return $records;

    }

}

class record {

    public function __construct(Array $fieldNames = null, $values = null )
    {
        $record = array_combine($fieldNames, $values);

        foreach ($record as $property => $value) {
            $this->createProperty($property, $value);
        }

    }

    public function returnArray() {
        $array = (array) $this;

        return $array;
    }

    public function createProperty($name = 'index', $value = '1') {

        $this->{$name} = $value;

    }
}

class recordFactory {

    public static function create(Array $fieldNames = null, Array $values = null) {


        $record = new record($fieldNames, $values);

        return $record;

    }
}















