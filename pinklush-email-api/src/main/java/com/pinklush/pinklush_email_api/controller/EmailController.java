package com.pinklush.pinklush_email_api.controller;

import com.pinklush.pinklush_email_api.dto.EmailRequest;
import com.pinklush.pinklush_email_api.service.EmailService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.HashMap;
import java.util.Map;

@RestController
@RequestMapping("/api/email")
@CrossOrigin(origins = "*")
public class EmailController {

    @Autowired
    private EmailService emailService;

    /**
     * Health check endpoint - tests if the API is running
     * GET http://localhost:8080/api/email/health
     */
    @GetMapping("/health")
    public ResponseEntity<Map<String, String>> healthCheck() {
        Map<String, String> response = new HashMap<>();
        response.put("status", "ok");
        response.put("service", "PinkLush Email API");
        response.put("timestamp", String.valueOf(System.currentTimeMillis()));
        return ResponseEntity.ok(response);
    }

    /**
     * Send appointment confirmation email
     * POST http://localhost:8080/api/email/send
     *
     * Request body example:
     * {
     *   "to": "customer@example.com",
     *   "customerName": "Jane Doe",
     *   "appointmentDate": "January 20, 2026 at 2:30 PM",
     *   "serviceName": "Hair Color - Medium",
     *   "branch": "IT Park, The Walk",
     *   "appointmentId": 12345
     * }
     */
    @PostMapping("/send")
    public ResponseEntity<Map<String, Object>> sendConfirmation(@RequestBody EmailRequest request) {
        Map<String, Object> response = new HashMap<>();

        try {
            // Validate required fields
            if (request.getTo() == null || request.getTo().isEmpty()) {
                response.put("success", false);
                response.put("message", "Recipient email address is required");
                return ResponseEntity.badRequest().body(response);
            }

            if (request.getCustomerName() == null || request.getCustomerName().isEmpty()) {
                response.put("success", false);
                response.put("message", "Customer name is required");
                return ResponseEntity.badRequest().body(response);
            }

            if (request.getAppointmentDate() == null || request.getAppointmentDate().isEmpty()) {
                response.put("success", false);
                response.put("message", "Appointment date is required");
                return ResponseEntity.badRequest().body(response);
            }

            // Send the email
            emailService.sendAppointmentConfirmation(request);

            response.put("success", true);
            response.put("message", "Confirmation email sent successfully to " + request.getTo());
            response.put("appointmentId", request.getAppointmentId());
            return ResponseEntity.ok(response);

        } catch (Exception e) {
            response.put("success", false);
            response.put("message", "Failed to send email: " + e.getMessage());
            response.put("error", e.getClass().getSimpleName());
            return ResponseEntity.status(500).body(response);
        }
    }

    /**
     * Simple test endpoint without requiring email sending
     * GET http://localhost:8080/api/email/test
     */
    @GetMapping("/test")
    public ResponseEntity<Map<String, String>> testEndpoint() {
        Map<String, String> response = new HashMap<>();
        response.put("status", "ok");
        response.put("message", "Email API is reachable!");
        response.put("endpoints", "GET /health, GET /test, POST /send");
        return ResponseEntity.ok(response);
    }
}