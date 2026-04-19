<script setup>

import { Button } from '@/components/ui/button/index.ts'
import { Input } from '@/components/ui/input/index.ts'
import {
    Card,
    CardTitle,
    CardHeader,
    CardDescription,
    CardContent,
    CardFooter,
    CardAction
} from '@/components/ui/card/index.ts'
</script>

<template>
    <div class="min-h-screen max-w-7xl mx-auto my-6">
        <Card>
            <CardHeader>
                <CardTitle>Basic Template</CardTitle>
                <CardDescription>Card Description</CardDescription>
            </CardHeader>
            <CardContent>
                <Input type="text" placeholder="Hi, Mom!"/>
            </CardContent>
            <CardFooter>
                <CardAction>
                    <Button>Click me</Button>
                </CardAction>
            </CardFooter>
        </Card>


    </div>

</template>

