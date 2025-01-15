<?php


class TileIconCounter extends IPSModule
{
    public function Create()
    {
         // Never delete this line!
         parent::Create();

         $this->SetVisualizationType(1);

         $this->RegisterVariableString("Data", "Data", "", 0);
    }

    public function ApplyChanges() {
        parent::ApplyChanges();

        $this->UpdateVisualizationValue($this->GetFullUpdateMessage());
    }

    public function MessageSink($TimeStamp, $SenderID, $Message, $Data) {
        //if ($SenderID === $this->ReadPropertyInteger($counterProperty)) {
        switch ($Message) {
            case VM_UPDATE:
                $this->UpdateVisualizationValue($this->GetFullUpdateMessage());
                break;
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