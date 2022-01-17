package com.example.installation.service;

import com.alibaba.fastjson.JSON;
import com.alibaba.fastjson.JSONObject;
import com.example.installation.utils.AccountSettings;
import com.example.installation.utils.CreateFileUtil;
import com.example.installation.utils.ResultList;
import org.springframework.stereotype.Service;

import java.io.File;

@Service
public class AccountService {

    public ResultList createJsonFile(String path ,AccountSettings accountSettings){
        ResultList resultList = new ResultList();
        File f= new File(path);
        if(!f.exists()){
            f.mkdirs();
        }
        JSON json = (JSON) JSONObject.toJSON(accountSettings);
        System.out.println(json.toString());
       boolean b= CreateFileUtil.createJsonFile(json.toString(), path, accountSettings.getFileName());
        System.out.println(b);
        if(b){
            resultList.setStatus("200");
            resultList.setMessage("保存完成");
        }else{
            resultList.setStatus("500");
            resultList.setMessage("保存失败");
        }
       return resultList;
    }

}
