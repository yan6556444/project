package com.example.installation.controller;

import com.example.installation.service.AccountService;
import com.example.installation.utils.AccountSettings;
import com.example.installation.utils.ResultList;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import javax.servlet.http.HttpServletRequest;

@RestController
@RequestMapping("inst")
public class InstallationController {
    @Autowired
    private AccountService accountService;
    @RequestMapping("create")
    public ResultList createNewCategory(@RequestBody AccountSettings accountSettings, HttpServletRequest request){
        String path=request.getServletContext().getRealPath("/jsonData");
        System.out.println(path);
        System.out.println(accountSettings);

        return accountService.createJsonFile(path,accountSettings);
    }
}
