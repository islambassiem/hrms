import { cn } from '@/lib/utils';
import { type ImgHTMLAttributes } from 'react';

export default function Logo({
    className,
    ...props
}: ImgHTMLAttributes<HTMLImageElement>) {
    return <img src="/logo.png" className={cn(className)} {...props} />;
}
