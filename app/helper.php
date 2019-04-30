<?php
use App\Links;
use App\User;
use App\UserSection;
  function getTotalLinks($sectionId,$user_id)
  {
    $data = 0; $returnDataArray = array();

    if($sectionId!=''){
      $data = Links::whereSection_id($sectionId)->whereCreatedby_id(Auth::user()->id)->get();
      $returnDataArray['totalClicks'] =   $data->sum('clicks');
      $returnDataArray['totallinksCount']  =   $data->count();

    }
  return $returnDataArray;
  }
  function getTotalLinksCompany($sectionId,$companyId)
  {
    $data = 0; $returnDataArray = array();
    //echo $sectionId.'--';
      if($companyId!='')
      {
      $userBelongsToCompany  = User::whereCompany_id($companyId)->pluck('id','id');
      $sectionList =  UserSection::whereIn('user_id', $userBelongsToCompany)->whereSection_id($sectionId)->count();
      $returnDataArray['sectionAlloted'] =   $sectionList;
      }

      if($sectionId!=''){
        $data = Links::whereIN('createdby_id',$userBelongsToCompany)->whereSection_id($sectionId)->get();
        $returnDataArray['totalClicks'] =   $data->sum('clicks');
        $returnDataArray['totallinksCount']  =   $data->count();
      }
      return $returnDataArray;
  }

  function getTotalLinksSuperAdmin($sectionId)
  {
    $data = 0; $returnDataArray = array();

    if($sectionId!=''){
      $sectionList                          =   UserSection::whereSection_id($sectionId)->count();
      $returnDataArray['sectionAlloted']    =   $sectionList;
      $data                                 =   Links::whereSection_id($sectionId)->get();
      $returnDataArray['totalClicks']       =   $data->sum('clicks');
      $returnDataArray['totallinksCount']   =   $data->count();

    }
  return $returnDataArray;
  }
?>
