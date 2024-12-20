from django.db import models
from authentication.models import Student

# Create your models here.

class PaymentMethod(models.Model):
    name = models.CharField(max_length=50, unique=True)
    is_active = models.BooleanField(default=True)

    def __str__(self):
        return self.name

class Payment(models.Model):
    PAYMENT_STATUS_CHOICES = [
        ('pending', 'Pending'),
        ('completed', 'Completed'),
        ('failed', 'Failed'),
    ]

    student = models.ForeignKey(Student, on_delete=models.CASCADE)
    amount = models.DecimalField(max_digits=10, decimal_places=2)
    payment_method = models.ForeignKey(PaymentMethod, on_delete=models.SET_NULL, null=True)
    transaction_id = models.CharField(max_length=100, unique=True)
    status = models.CharField(max_length=20, choices=PAYMENT_STATUS_CHOICES, default='pending')
    timestamp = models.DateTimeField(auto_now_add=True)
    receipt_url = models.URLField(blank=True, null=True)

    def __str__(self):
        return f"{self.student.username} - {self.amount} - {self.status}"

class FeeStructure(models.Model):
    department = models.CharField(max_length=100)
    academic_year = models.CharField(max_length=20)
    total_fees = models.DecimalField(max_digits=10, decimal_places=2)
    semester_fees = models.DecimalField(max_digits=10, decimal_places=2)
    additional_charges = models.DecimalField(max_digits=10, decimal_places=2, default=0)

    def __str__(self):
        return f"{self.department} - {self.academic_year}"
