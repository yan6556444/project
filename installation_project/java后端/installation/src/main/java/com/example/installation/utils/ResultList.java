package com.example.installation.utils;

import com.fasterxml.jackson.annotation.JsonInclude;

import java.util.List;
import java.util.Map;

public class ResultList {

    private String status="200";

    private String message="ok";
    @JsonInclude(JsonInclude.Include.NON_NULL)
    private Object obj;
    @JsonInclude(JsonInclude.Include.NON_NULL)
    private List list;
    @JsonInclude(JsonInclude.Include.NON_NULL)
    private Map map;

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public String getMessage() {
        return message;
    }

    public void setMessage(String message) {
        this.message = message;
    }

    public Object getObj() {
        return obj;
    }

    public void setObj(Object obj) {
        this.obj = obj;
    }

    public List getList() {
        return list;
    }

    public void setList(List list) {
        this.list = list;
    }

    public Map getMap() {
        return map;
    }

    public void setMap(Map map) {
        this.map = map;
    }
}
