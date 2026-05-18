package com.pinklush.pinklush_email_api.dto;

public class EmailRequest {
    private String to;
    private String customerName;
    private String appointmentDate;
    private String serviceName;
    private String branch;
    private Long appointmentId;

    // Getters
    public String getTo() { return to; }
    public String getCustomerName() { return customerName; }
    public String getAppointmentDate() { return appointmentDate; }
    public String getServiceName() { return serviceName; }
    public String getBranch() { return branch; }
    public Long getAppointmentId() { return appointmentId; }

    // Setters
    public void setTo(String to) { this.to = to; }
    public void setCustomerName(String customerName) { this.customerName = customerName; }
    public void setAppointmentDate(String appointmentDate) { this.appointmentDate = appointmentDate; }
    public void setServiceName(String serviceName) { this.serviceName = serviceName; }
    public void setBranch(String branch) { this.branch = branch; }
    public void setAppointmentId(Long appointmentId) { this.appointmentId = appointmentId; }
}