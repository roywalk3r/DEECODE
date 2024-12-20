import os
import django

os.environ.setdefault('DJANGO_SETTINGS_MODULE', 'school_payment_portal.settings')
django.setup()

from authentication.models import Student

# Create superuser
if not Student.objects.filter(username='admin').exists():
    Student.objects.create_superuser(
        username='admin',
        email='admin@example.com',
        password='admin123',
        student_id='ADMIN001'
    )
    print("Superuser created successfully!")
else:
    print("Superuser already exists.")
