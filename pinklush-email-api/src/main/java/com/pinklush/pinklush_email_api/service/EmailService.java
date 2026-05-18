package com.pinklush.pinklush_email_api.service;

import com.pinklush.pinklush_email_api.dto.EmailRequest;
import jakarta.mail.MessagingException;
import jakarta.mail.internet.MimeMessage;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.mail.javamail.JavaMailSender;
import org.springframework.mail.javamail.MimeMessageHelper;
import org.springframework.stereotype.Service;

import java.io.UnsupportedEncodingException;

@Service
public class EmailService {

    @Autowired
    private JavaMailSender mailSender;

    @Value("${pinklush.email.from}")
    private String fromEmail;

    @Value("${pinklush.email.reply-to}")
    private String replyToEmail;

    public void sendAppointmentConfirmation(EmailRequest request) throws MessagingException, UnsupportedEncodingException {
        MimeMessage message = mailSender.createMimeMessage();
        MimeMessageHelper helper = new MimeMessageHelper(message, true, "UTF-8");

        String htmlContent = buildEmailHtml(request);

        helper.setFrom(fromEmail, "PinkLush Beauty Lounge");
        helper.setTo(request.getTo());
        
        if (replyToEmail != null && !replyToEmail.isEmpty()) {
            helper.setReplyTo(replyToEmail);
        }
        
        helper.setSubject("PinkLush Appointment Confirmation #" + request.getAppointmentId());
        helper.setText(htmlContent, true);

        mailSender.send(message);
        System.out.println("Email sent to: " + request.getTo());
    }

    private String buildEmailHtml(EmailRequest request) {
        StringBuilder html = new StringBuilder();
        
        html.append("<!DOCTYPE html>\n");
        html.append("<html>\n");
        html.append("<head>\n");
        html.append("<meta charset=\"UTF-8\">\n");
        html.append("<style>\n");
        html.append("body { font-family: Arial, sans-serif; background-color: #f9f5f7; margin: 0; padding: 20px; }\n");
        html.append(".container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }\n");
        html.append(".header { background: linear-gradient(135deg, #ff69b4, #ff1493); padding: 30px; text-align: center; }\n");
        html.append(".header h1 { color: white; margin: 0; font-size: 28px; }\n");
        html.append(".content { padding: 30px; }\n");
        html.append(".greeting { font-size: 20px; color: #4a4a4a; margin-bottom: 20px; }\n");
        html.append(".details { background-color: #fff5f7; border-left: 4px solid #ff69b4; padding: 20px; margin: 20px 0; border-radius: 8px; }\n");
        html.append(".details p { margin: 10px 0; }\n");
        html.append(".reference { background-color: #f0f0f0; text-align: center; padding: 15px; border-radius: 8px; margin: 20px 0; }\n");
        html.append(".reference span { color: #ff1493; font-size: 24px; font-weight: bold; }\n");
        html.append(".auto-message { background-color: #fff8e0; padding: 10px; border-radius: 5px; margin-top: 15px; font-size: 11px; text-align: center; color: #856404; }\n");
        html.append(".footer { background-color: #f9f5f7; padding: 20px; text-align: center; font-size: 12px; color: #999; }\n");
        html.append("</style>\n");
        html.append("</head>\n");
        html.append("<body>\n");
        html.append("<div class=\"container\">\n");
        html.append("<div class=\"header\">\n");
        html.append("<h1>✨ PinkLush Beauty Lounge ✨</h1>\n");
        html.append("</div>\n");
        html.append("<div class=\"content\">\n");
        html.append("<div class=\"greeting\">Hello <strong>" + escapeHtml(request.getCustomerName()) + "</strong>!</div>\n");
        html.append("<p>Thank you for choosing <strong>PinkLush Beauty Lounge</strong>! Your appointment has been confirmed.</p>\n");
        html.append("<div class=\"details\">\n");
        html.append("<p><strong>📅 Date & Time:</strong> " + escapeHtml(request.getAppointmentDate()) + "</p>\n");
        html.append("<p><strong>💇 Service:</strong> " + escapeHtml(request.getServiceName()) + "</p>\n");
        html.append("<p><strong>📍 Branch:</strong> " + escapeHtml(request.getBranch()) + "</p>\n");
        html.append("</div>\n");
        html.append("<div class=\"reference\">\n");
        html.append("📌 Booking Reference #<span>" + request.getAppointmentId() + "</span>\n");
        html.append("</div>\n");
        html.append("<div class=\"auto-message\">\n");
        html.append("⚠️ <strong>Auto-generated message - Please do not reply to this email</strong>\n");
        html.append("</div>\n");
        html.append("</div>\n");
        html.append("<div class=\"footer\">\n");
        html.append("© 2025 PinkLush Beauty Lounge | Look Good, Feel Amazing!\n");
        html.append("</div>\n");
        html.append("</div>\n");
        html.append("</body>\n");
        html.append("</html>\n");
        
        return html.toString();
    }
    
    private String escapeHtml(String input) {
        if (input == null) return "";
        return input
            .replace("&", "&amp;")
            .replace("<", "&lt;")
            .replace(">", "&gt;")
            .replace("\"", "&quot;")
            .replace("'", "&#39;");
    }
}