import LocaleSync from '@/components/locale-sync';

export default function RootLayout({
    children,
}: {
    children: React.ReactNode;
}) {
    return (
        <>
            <LocaleSync />
            {children}
        </>
    );
}
