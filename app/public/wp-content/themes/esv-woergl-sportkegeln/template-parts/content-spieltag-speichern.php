<div> 
<?php               if (isset($_REQUEST['inhalt']) and trim($_REQUEST['inhalt']) <> '') {
                        $zeileninhalt = explode("\r", $_REQUEST['inhalt']);

                        foreach ($zeileninhalt AS $nr => $zeile) {
                            $daten[$nr] = explode("\t", trim($zeile));
                        }
                        echo "<pre>";
                        print_r($daten);
                        exit;
                    }   ?>
                    <form name="" action="" method="post">
                        <textarea name="inhalt" rows="10"   cols="160"></textarea>
                        <br>
                        <input name="" type="submit" value="speichern">
                    </form>
                </div>