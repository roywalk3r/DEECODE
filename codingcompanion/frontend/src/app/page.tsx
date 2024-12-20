'use client'

import { useState, useRef, useEffect } from 'react'
import { Button } from "@/components/ui/button"
import { Textarea } from "@/components/ui/textarea"
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card"
import { ScrollArea } from "@/components/ui/scroll-area"
import { Loader2, Send, Reply } from "lucide-react"
import { Prism as SyntaxHighlighter } from 'react-syntax-highlighter'
import { vscDarkPlus } from 'react-syntax-highlighter/dist/esm/styles/prism'

interface Message {
  id: number;
  role: 'user' | 'ai';
  content: string;
  replyTo?: number;
}

export default function Home() {
  const [messages, setMessages] = useState<Message[]>([])
  const [input, setInput] = useState('')
  const [loading, setLoading] = useState(false)
  const [replyingTo, setReplyingTo] = useState<number | null>(null)
  const messagesEndRef = useRef<HTMLDivElement>(null)

  const scrollToBottom = () => {
    messagesEndRef.current?.scrollIntoView({ behavior: "smooth" })
  }

  useEffect(scrollToBottom, [messages])

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault()
    if (!input.trim()) return

    const newMessage: Message = {
      id: Date.now(),
      role: 'user',
      content: input,
      replyTo: replyingTo
    }

    setMessages(prev => [...prev, newMessage])
    setInput('')
    setReplyingTo(null)
    setLoading(true)

    try {
      const res = await fetch('http://localhost:3000/api/gemini/generate', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Access-Control-Allow-Origin': '*',
        },
        body: JSON.stringify({ prompt: input })
      })

      if (!res.ok) throw new Error('Failed to get response')

      const data = await res.json()
      const aiResponse: Message = {
        id: Date.now(),
        role: 'ai',
        content: data.response
      }
      setMessages(prev => [...prev, aiResponse])
    } catch (error) {
      console.error(error)
      const errorMessage: Message = {
        id: Date.now(),
        role: 'ai',
        content: 'Error fetching response'
      }
      setMessages(prev => [...prev, errorMessage])
    } finally {
      setLoading(false)
    }
  }

  const formatContent = (content: string) => {
    const codeBlockRegex = /```(\w+)?\s*([\s\S]*?)```/g
    const parts = []
    let lastIndex = 0
    let match

    while ((match = codeBlockRegex.exec(content)) !== null) {
      if (match.index > lastIndex) {
        parts.push(<p key={lastIndex} className="mb-4">{content.slice(lastIndex, match.index)}</p>)
      }
      const language = match[1] || 'javascript'
      parts.push(
          <SyntaxHighlighter
              key={match.index}
              language={language}
              style={vscDarkPlus}
              className="rounded-md mb-4"
          >
            {match[2].trim()}
          </SyntaxHighlighter>
      )
      lastIndex = match.index + match[0].length
    }

    if (lastIndex < content.length) {
      parts.push(<p key={lastIndex} className="mb-4">{content.slice(lastIndex)}</p>)
    }

    return parts
  }

  const handleReply = (id: number) => {
    setReplyingTo(id)
    setInput(`Replying to: "${messages.find(m => m.id === id)?.content.slice(0, 50)}..."\n\n`)
  }

  return (
      <div className="container mx-auto p-4">
        <Card className="w-full max-w-4xl mx-auto">
          <CardHeader>
            <CardTitle className="text-2xl font-bold text-center">Gemini Coding Companion</CardTitle>
          </CardHeader>
          <CardContent>
            <ScrollArea className="h-[60vh] mb-4 p-4 border rounded">
              {messages.map((message, index) => (
                  <div key={message.id} className={`mb-4 ${message.role === 'user' ? 'text-blue-600' : 'text-green-600'}`}>
                    <div className="flex items-start">
                      <div className="flex-grow">
                        <strong>{message.role === 'user' ? 'You: ' : 'AI: '}</strong>
                        {message.replyTo && (
                            <div className="text-sm text-gray-500 mb-1">
                              Replying to: "{messages.find(m => m.id === message.replyTo)?.content.slice(0, 50)}..."
                            </div>
                        )}
                        <div className="mt-1">{formatContent(message.content)}</div>
                      </div>
                      <Button
                          variant="ghost"
                          size="icon"
                          onClick={() => handleReply(message.id)}
                          className="ml-2"
                          aria-label="Reply to this message"
                      >
                        <Reply className="h-4 w-4" />
                      </Button>
                    </div>
                  </div>
              ))}
              <div ref={messagesEndRef} />
            </ScrollArea>
            <form onSubmit={handleSubmit} className="space-y-4">
              {replyingTo && (
                  <div className="text-sm text-gray-500">
                    Replying to: "{messages.find(m => m.id === replyingTo)?.content.slice(0, 50)}..."
                    <Button
                        variant="ghost"
                        size="sm"
                        onClick={() => setReplyingTo(null)}
                        className="ml-2"
                    >
                      Cancel Reply
                    </Button>
                  </div>
              )}
              <div className="flex items-center space-x-2">
                <Textarea
                    value={input}
                    onChange={(e) => setInput(e.target.value)}
                    placeholder="Enter your coding question or prompt..."
                    className="flex-grow"
                    rows={3}
                />
                <Button type="submit" disabled={loading} size="icon">
                  {loading ? <Loader2 className="h-4 w-4 animate-spin" /> : <Send className="h-4 w-4" />}
                </Button>
              </div>
            </form>
          </CardContent>
        </Card>
      </div>
  )
}