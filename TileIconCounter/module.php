<?php


class TileIconCounter extends IPSModule
{
    public function Create()
    {
         // Never delete this line!
         parent::Create();

         // Visualisierungstyp auf 1 setzen, da wir HTML anbieten möchten
         $this->SetVisualizationType(1);
    }

    public function ApplyChanges() {
        parent::ApplyChanges();

        $this->UpdateVisualizationValue($this->GetFullUpdateMessage());
    }

    public function GetVisualizationTile() {
        $initialHandling = '<script>handleMessage(' . json_encode($this->GetFullUpdateMessage()) . ');</script>';

        $module = file_get_contents(__DIR__ . '/module.html');

        return $module . $initialHandling;
    }

    private function GetFullUpdateMessage() {
        return json_encode([
        ]);
    }
}