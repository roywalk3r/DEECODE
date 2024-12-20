from django.contrib.auth.models import AbstractUser
from django.db import models

# Create your models here.

class Student(AbstractUser):
    student_id = models.CharField(max_length=20, unique=True)
    phone_number = models.CharField(max_length=15, blank=True, null=True)
    is_active_student = models.BooleanField(default=True)
    
    def __str__(self):
        return f"{self.username} - {self.student_id}"

class StudentProfile(models.Model):
    student = models.OneToOneField(Student, on_delete=models.CASCADE)
    department = models.CharField(max_length=100)
    total_fees = models.DecimalField(max_digits=10, decimal_places=2, default=0)
    
    def __str__(self):
        return f"{self.student.username} Profile"
