import React, { useState } from 'react'
import Layout from '../components/Layout'
import { Button } from "@/components/ui/button"
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from "@/components/ui/table"
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog"

interface Course {
    id: number
    name: string
    teacher: string
    students: number
}

const initialCourses: Course[] = [
    { id: 1, name: 'Advanced Mathematics', teacher: 'Dr. Emily White', students: 30 },
    { id: 2, name: 'Physics 101', teacher: 'Prof. David Lee', students: 25 },
    { id: 3, name: 'English Literature', teacher: 'Ms. Sarah Green', students: 35 },
]

export default function Courses() {
    const [courses, setCourses] = useState<Course[]>(initialCourses)
    const [newCourse, setNewCourse] = useState<Omit<Course, 'id'>>({ name: '', teacher: '', students: 0 })

    const handleAddCourse = () => {
        const id = courses.length + 1
        setCourses([...courses, { ...newCourse, id }])
        setNewCourse({ name: '', teacher: '', students: 0 })
    }

    return (
        <Layout>
            <div className="flex justify-between items-center mb-6">
                <h2 className="text-3xl font-bold tracking-tight">Courses</h2>
                <Dialog>
                    <DialogTrigger asChild>
                        <Button>Add Course</Button>
                    </DialogTrigger>
                    <DialogContent className="sm:max-w-[425px]">
                        <DialogHeader>
                            <DialogTitle>Add New Course</DialogTitle>
                            <DialogDescription>
                                Enter the details of the new course here. Click save when you're done.
                            </DialogDescription>
                        </DialogHeader>
                        <div className="grid gap-4 py-4">
                            <div className="grid grid-cols-4 items-center gap-4">
                                <Label htmlFor="name" className="text-right">
                                    Name
                                </Label>
                                <Input
                                    id="name"
                                    value={newCourse.name}
                                    onChange={(e) => setNewCourse({ ...newCourse, name: e.target.value })}
                                    className="col-span-3"
                                />
                            </div>
                            <div className="grid grid-cols-4 items-center gap-4">
                                <Label htmlFor="teacher" className="text-right">
                                    Teacher
                                </Label>
                                <Input
                                    id="teacher"
                                    value={newCourse.teacher}
                                    onChange={(e) => setNewCourse({ ...newCourse, teacher: e.target.value })}
                                    className="col-span-3"
                                />
                            </div>
                            <div className="grid grid-cols-4 items-center gap-4">
                                <Label htmlFor="students" className="text-right">
                                    Students
                                </Label>
                                <Input
                                    id="students"
                                    type="number"
                                    value={newCourse.students}
                                    onChange={(e) => setNewCourse({ ...newCourse, students: parseInt(e.target.value) })}
                                    className="col-span-3"
                                />
                            </div>
                        </div>
                        <DialogFooter>
                            <Button type="submit" onClick={handleAddCourse}>Save changes</Button>
                        </DialogFooter>
                    </DialogContent>
                </Dialog>
            </div>
            <Table>
                <TableCaption>A list of all courses.</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead className="w-[100px]">ID</TableHead>
                        <TableHead>Name</TableHead>
                        <TableHead>Teacher</TableHead>
                        <TableHead className="text-right">Students</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    {courses.map((course) => (
                        <TableRow key={course.id}>
                            <TableCell className="font-medium">{course.id}</TableCell>
                            <TableCell>{course.name}</TableCell>
                            <TableCell>{course.teacher}</TableCell>
                            <TableCell className="text-right">{course.students}</TableCell>
                        </TableRow>
                    ))}
                </TableBody>
            </Table>
        </Layout>
    )
}

