package com.example.installation.filter;


import com.example.installation.utils.WsServer;
import org.springframework.stereotype.Component;

import javax.servlet.*;
import java.io.IOException;

@Component
public class StartFilter implements Filter {

    public void destroy() {

    }

    public void doFilter(ServletRequest request, ServletResponse response,
                         FilterChain chain) throws IOException, ServletException {
            chain.doFilter(request,response);
    }

    public void init(FilterConfig arg0) throws ServletException {
        this.startWebsocketInstantMsg();
    }

    /**
     * 启动即时聊天服务
     */
    public void startWebsocketInstantMsg() {
        WsServer s;
        s = new WsServer(8887);
        s.start();
    }
}
