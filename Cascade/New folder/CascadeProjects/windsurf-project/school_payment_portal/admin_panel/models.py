from django.db import models
from authentication.models import Student
from payments.models import Payment

# Create your models here.

class AdminNotification(models.Model):
    NOTIFICATION_TYPES = [
        ('payment_reminder', 'Payment Reminder'),
        ('fee_update', 'Fee Update'),
        ('system_alert', 'System Alert'),
    ]

    title = models.CharField(max_length=200)
    message = models.TextField()
    notification_type = models.CharField(max_length=50, choices=NOTIFICATION_TYPES)
    recipient = models.ForeignKey(Student, on_delete=models.CASCADE, null=True, blank=True)
    is_read = models.BooleanField(default=False)
    created_at = models.DateTimeField(auto_now_add=True)

    def __str__(self):
        return f"{self.title} - {self.notification_type}"

class SystemConfig(models.Model):
    key = models.CharField(max_length=100, unique=True)
    value = models.TextField()
    description = models.CharField(max_length=255, blank=True)
    is_active = models.BooleanField(default=True)

    def __str__(self):
        return self.key
