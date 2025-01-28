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
            $this->SetValue('Data', $Value);
            $this->UpdateVisualizationValue($this->GetFullUpdateMessage());
        } else {
            $adjust = strpos($Ident, 'adjust:') === 0;
            if($adjust) {
                $Ident = explode(':', $Ident)[1];
            }

            // resolve links first
            $obj = IPS_GetObject($Ident);
                if($obj['ObjectType'] === 6) {
                    $link = @IPS_GetLink($Ident);
                    if(!$link) return;
                    $Ident = $link['TargetID'];
            }

            $obj = IPS_GetObject($Ident);
            if($obj['ObjectType'] === 3) {
            IPS_RunScript($Ident);
            } else if($obj['ObjectType'] === 2) {
            if($adjust) $Value = GetValue($Ident) + $Value;
                RequestAction($Ident, $Value);
            }
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
