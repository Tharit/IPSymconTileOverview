<?php


class TileIconCounter extends IPSModule
{
    public function Create()
    {
         // Never delete this line!
         parent::Create();

         $this->SetVisualizationType(1);

         $this->RegisterVariableString("Data", "Data", "", 0);
         $this->EnableAction("Data");
    }

    public function ApplyChanges() {
        parent::ApplyChanges();

        $this->UpdateVisualizationValue($this->GetFullUpdateMessage());
    }

    public function RequestAction($Ident, $Value)
    {
        if($Ident === 'Data') {
            $this->UpdateVisualizationValue($this->GetFullUpdateMessage());
        }
    }

    public function GetVisualizationTile() {
        $initialHandling = '<script>handleMessage(' . json_encode($this->GetFullUpdateMessage()) . ');</script>';

        $module = file_get_contents(__DIR__ . '/module.html');

        return $module . $initialHandling;
    }

    private function GetFullUpdateMessage() {
        return $this->GetValue('Data');
    }
}