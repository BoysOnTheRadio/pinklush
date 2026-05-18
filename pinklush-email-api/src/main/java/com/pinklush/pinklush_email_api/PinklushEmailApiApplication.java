package com.pinklush.pinklush_email_api;

import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;

@SpringBootApplication
public class PinklushEmailApiApplication {
	public static void main(String[] args) {
		SpringApplication.run(PinklushEmailApiApplication.class, args);
		System.out.println("PinkLush Email API is running on http://localhost:8080");
	}
}