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
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select"

interface Student {
    id: number
    name: string
    email: string
    grade: string
}

const initialStudents: Student[] = [
    { id: 1, name: 'Alice Johnson', email: 'alice@example.com', grade: '10th' },
    { id: 2, name: 'Bob Smith', email: 'bob@example.com', grade: '11th' },
    { id: 3, name: 'Charlie Brown', email: 'charlie@example.com', grade: '9th' },
]

export default function Students() {
    const [students, setStudents] = useState<Student[]>(initialStudents)
    const [newStudent, setNewStudent] = useState<Omit<Student, 'id'>>({ name: '', email: '', grade: '' })

    const handleAddStudent = () => {
        const id = students.length + 1
        setStudents([...students, { ...newStudent, id }])
        setNewStudent({ name: '', email: '', grade: '' })
    }

    return (
        <Layout>
            <div className="flex justify-between items-center mb-6">
                <h2 className="text-3xl font-bold tracking-tight">Students</h2>
                <Dialog>
                    <DialogTrigger asChild>
                        <Button>Add Student</Button>
                    </DialogTrigger>
                    <DialogContent className="sm:max-w-[425px]">
                        <DialogHeader>
                            <DialogTitle>Add New Student</DialogTitle>
                            <DialogDescription>
                                Enter the details of the new student here. Click save when you're done.
                            </DialogDescription>
                        </DialogHeader>
                        <div className="grid gap-4 py-4">
                            <div className="grid grid-cols-4 items-center gap-4">
                                <Label htmlFor="name" className="text-right">
                                    Name
                                </Label>
                                <Input
                                    id="name"
                                    value={newStudent.name}
                                    onChange={(e) => setNewStudent({ ...newStudent, name: e.target.value })}
                                    className="col-span-3"
                                />
                            </div>
                            <div className="grid grid-cols-4 items-center gap-4">
                                <Label htmlFor="email" className="text-right">
                                    Email
                                </Label>
                                <Input
                                    id="email"
                                    type="email"
                                    value={newStudent.email}
                                    onChange={(e) => setNewStudent({ ...newStudent, email: e.target.value })}
                                    className="col-span-3"
                                />
                            </div>
                            <div className="grid grid-cols-4 items-center gap-4">
                                <Label htmlFor="grade" className="text-right">
                                    Grade
                                </Label>
                                <Select
                                    value={newStudent.grade}
                                    onValueChange={(value) => setNewStudent({ ...newStudent, grade: value })}
                                >
                                    <SelectTrigger className="col-span-3">
                                        <SelectValue placeholder="Select grade" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectItem value="9th">9th</SelectItem>
                                        <SelectItem value="10th">10th</SelectItem>
                                        <SelectItem value="11th">11th</SelectItem>
                                        <SelectItem value="12th">12th</SelectItem>
                                    </SelectContent>
                                </Select>
                            </div>
                        </div>
                        <DialogFooter>
                            <Button type="submit" onClick={handleAddStudent}>Save changes</Button>
                        </DialogFooter>
                    </DialogContent>
                </Dialog>
            </div>
            <Table>
                <TableCaption>A list of all students.</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead className="w-[100px]">ID</TableHead>
                        <TableHead>Name</TableHead>
                        <TableHead>Email</TableHead>
                        <TableHead>Grade</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    {students.map((student) => (
                        <TableRow key={student.id}>
                            <TableCell className="font-medium">{student.id}</TableCell>
                            <TableCell>{student.name}</TableCell>
                            <TableCell>{student.email}</TableCell>
                            <TableCell>{student.grade}</TableCell>
                        </TableRow>
                    ))}
                </TableBody>
            </Table>
        </Layout>
    )
}

